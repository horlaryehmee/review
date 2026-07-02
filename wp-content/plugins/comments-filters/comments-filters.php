<?php
/*
Plugin Name: Comments Filters
Plugin URI: #
Description: With Comments Filters you can filter your comments by users type, comments date and type of comments: if have a reply or not.
Version: 1.0
Author: Marco Peca
Author URI: https://www.marcopeca.it/
*/

class Comments_Filters {

    public $debug;

    public function __construct($debug = FALSE) {
        $this->debug = $debug;
        add_action( 'admin_init', array($this, 'setup_hooks'));
    }

    public function setup_hooks(){
        add_action( 'restrict_manage_comments', array($this,'wpce3_author_comments_include_filter'));
        //add_action( 'restrict_manage_comments', array($this,'wpce3_author_comments_exclude_filter'));
        add_action( 'restrict_manage_comments', array($this,'wpce3_date_comments_filter'));
        add_action( 'restrict_manage_comments', array($this,'wpce3_type_comments_filter'));

        add_filter( 'comments_clauses', array( $this, 'wpce3_comment_sort_query' ),10,2 );
    }

    public function wpce3_comment_sort_query($clauses, $query = null){
        $filter_include_author = $this->get_current_author_include_filter();
        $filter_exclude_author = $this->get_current_author_exclude_filter();
        $filter_type = $this->get_current_type_filter();
        $filter_date = $this->get_current_date_filter();
        
        if($this->debug){
            echo '<div id="wpbody" role="main">
            <div id="wpbody-content">';
            $this->debug_on_screen("Includi ","h3");
            var_dump($filter_include_author);

            $this->debug_on_screen("Escludi ","h3");
            var_dump($filter_exclude_author);

            $this->debug_on_screen("Filtro Tipo Commento ","h3");
            var_dump($filter_type);

            $this->debug_on_screen("Data Commenti","h3");
            var_dump($filter_date);
            echo '</div></div>';
        }

        global $wpdb;
        $pref = $wpdb->prefix;        

        $where = isset( $clauses['where'] ) ? $clauses['where'] : '';
        $join = isset( $clauses['join'] ) ? $clauses['join'] : '';

        $append_where = function( $condition ) use ( &$where ) {
            if ( $where ) {
                $where .= ' AND ' . $condition;
            } else {
                $where = $condition;
            }
        };

        $append_join = function( $fragment, $needle = '' ) use ( &$join ) {
            if ( $needle && strpos( $join, $needle ) !== false ) {
                return;
            }

            if ( $join ) {
                $join .= ' ' . $fragment;
            } else {
                $join = $fragment;
            }
        };
        
        //$str = explode("AND",$clauses['where']);
        //$clauses['where'] = $str[0];        


        // Includi autori
        if($filter_include_author == "0"){
            $append_where( $pref . "comments.user_id = 0" );
        } else if($filter_include_author != "" && $filter_include_author != "0"){
            $append_join( "INNER JOIN {$wpdb->usermeta} AS cf_um ON cf_um.user_id = {$wpdb->comments}.user_id", 'cf_um' );
            $append_where( $wpdb->prepare( "cf_um.meta_key = %s", $pref . 'capabilities' ) );
            $append_where( $wpdb->prepare( "cf_um.meta_value LIKE %s", '%' . $wpdb->esc_like( $filter_include_author ) . '%' ) );
        }

        // Escludi autori
        if($filter_exclude_author == "0"){
            $append_where( $pref . "comments.user_id = 0" );
        } else if($filter_exclude_author != "" && $filter_exclude_author != "0"){
            $append_join( "INNER JOIN {$wpdb->usermeta} AS cf_um ON cf_um.user_id = {$wpdb->comments}.user_id", 'cf_um' );
            $append_where( $wpdb->prepare( "cf_um.meta_key = %s", $pref . 'capabilities' ) );
            $append_where( $wpdb->prepare( "cf_um.meta_value NOT LIKE %s", '%' . $wpdb->esc_like( $filter_exclude_author ) . '%' ) );
        }
        
        //  Commenti con o senza risposta        
        $subquery = "SELECT C.comment_parent FROM ".$pref."comments C WHERE C.comment_parent != 0";
        if($filter_type == "0"){            
            $append_where( $pref . "comments.comment_ID NOT IN ($subquery)" );
        } else if($filter_type == "1"){
            $append_where( $pref . "comments.comment_ID IN ($subquery)" );
        }        

        //  Filtro per data
        if($filter_date !=  ""  && $filter_date != "0"){
            $append_where( $pref . "comments.comment_date BETWEEN DATE_SUB(NOW(), INTERVAL " . (int) $filter_date . " DAY) AND NOW()" );
        }

        // Extend admin search to include listing/business title.
        if ( $query instanceof WP_Comment_Query && ! empty( $query->query_vars['search'] ) ) {
            $search_term = $query->query_vars['search'];
            $comment_columns = array( 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_IP', 'comment_content' );
            $base_search = preg_replace( '/^\s*AND\s*/', '', $query->get_search_sql( $search_term, $comment_columns ) );

            if ( $base_search ) {
                $append_join( "JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->comments}.comment_post_ID", $wpdb->posts );

                $extended_columns = array_merge( $comment_columns, array( "{$wpdb->posts}.post_title" ) );
                $extended_search = preg_replace( '/^\s*AND\s*/', '', $query->get_search_sql( $search_term, $extended_columns ) );

                if ( $extended_search ) {
                    if ( $where && strpos( $where, $base_search ) !== false ) {
                        $where = str_replace( $base_search, $extended_search, $where );
                    } else {
                        $append_where( $extended_search );
                    }
                }
            }
        }
        
        if($this->debug){
            var_dump($clauses);            
        }

        $clauses['where'] = $where;
        $clauses['join'] = $join;
        return $clauses;        
    }

    public function wpce3_type_comments_filter(){
        $filter_type = $this->get_current_type_filter();

        echo '<label class="screen-reader-text" for="type_comment_filter">' . esc_html__( 'Filtra per Tipo di Commento', 'comments-filters' ) . '</label>';
        echo '<select name="type_comment_filter" id="">';
        if($filter_type == ""){
            echo $this->generate_option( '', __( 'Tutti i commenti', 'comments-filters' ),TRUE);
        } else {
            echo $this->generate_option( '', __( 'Tutti i commenti', 'comments-filters' ));
        }

        if($filter_type == "1"){
            echo $this->generate_option( '1', __( 'Commenti con risposta', 'comments-filters' ),TRUE);
        } else {
            echo $this->generate_option( '1', __( 'Commenti con risposta', 'comments-filters' ));
        }

        if($filter_type == "0"){
            echo $this->generate_option( '0', __( 'Commenti senza risposta', 'comments-filters' ),TRUE);
        } else {
            echo $this->generate_option( '0', __( 'Commenti senza risposta', 'comments-filters' ));        
        }

        echo '</select>';
    }
    
    public function wpce3_date_comments_filter(){
        $filter_date = $this->get_current_date_filter();        

        echo '<label class="screen-reader-text" for="date_comment_filter">' . esc_html__( 'Filtra per Data Commento', 'comments-filters' ) . '</label>';
        echo '<select name="date_comment_filter" id="">';
        if($filter_date == ""){
            echo $this->generate_option( '', __( 'Tutte le date', 'comments-filters' ),TRUE);
        } else {
            echo $this->generate_option( '', __( 'Tutte le date', 'comments-filters' ));
        }

        if($filter_date == "1"){
            echo $this->generate_option( '1', __( 'Ultime 24 Ore', 'comments-filters' ),TRUE);
        } else {
            echo $this->generate_option( '1', __( 'Ultime 24 Ore', 'comments-filters' ));
        }

        if($filter_date == "3"){
            echo $this->generate_option( '3', __( 'Ultimi 3 giorni', 'comments-filters' ), TRUE);
        } else {
            echo $this->generate_option( '3', __( 'Ultimi 3 giorni', 'comments-filters' ));
        }

        if($filter_date == "7"){
            echo $this->generate_option( '7', __( 'Ultimi 7 giorni', 'comments-filters' ), TRUE);
        } else {
            echo $this->generate_option( '7', __( 'Ultimi 7 giorni', 'comments-filters' ));
        }

        if($filter_date == "30"){
            echo $this->generate_option( '30', __( 'Ultimi 30 giorni', 'comments-filters' ), TRUE);
        } else {
            echo $this->generate_option( '30', __( 'Ultimi 30 giorni', 'comments-filters' ));
        }

        echo '</select>';
    }

    public function wpce3_author_comments_include_filter(){
        $filter = $this->get_current_author_include_filter();

        echo '<label class="screen-reader-text" for="author_comment_inlude_filter">' . esc_html__( 'Filtra per Autore Commento', 'comments-filters' ) . '</label>';
        echo '<select name="author_comment_inlude_filter" id="">';
        echo $this->generate_option( '', __( 'Utenti da includere', 'comments-filters' ));
        if($filter != "" && $filter == "0"){
            echo $this->generate_option( '0', __( 'Utenti non loggati', 'comments-filters' ), TRUE);       
        }  else  {
            echo $this->generate_option( '0', __( 'Utenti non loggati', 'comments-filters' ) );
        } 

        if($filter != "" && $filter != "0"){
            echo wp_dropdown_roles($filter);
        }  else {
            echo wp_dropdown_roles();    
        }        

        echo '</select>';
    } 

    public function wpce3_author_comments_exclude_filter(){
        $filter = $this->get_current_author_exclude_filter();

        echo '<label class="screen-reader-text" for="author_comment_exclude_filter">' . esc_html__( 'Filtra per Autore Commento', 'comments-filters' ) . '</label>';
        echo '<select name="author_comment_exclude_filter" id="">';
        echo $this->generate_option( '', __( 'Utenti da escludere', 'comments-filters' ));
        if($filter != "" && $filter == "0"){
            echo $this->generate_option( '0', __( 'Utenti non loggati', 'comments-filters' ), TRUE);       
        }  else  {
            echo $this->generate_option( '0', __( 'Utenti non loggati', 'comments-filters' ) );
        } 

        if($filter != "" && $filter != "0"){
            echo wp_dropdown_roles($filter);
        }  else {
            echo wp_dropdown_roles();    
        }        

        echo '</select>';
    } 

    public function get_current_date_filter(){
        return filter_input( INPUT_GET, 'date_comment_filter' );
    }

    public function get_current_type_filter(){
        return filter_input( INPUT_GET, 'type_comment_filter' );
    }

    public function get_current_author_include_filter() {
        return filter_input( INPUT_GET, 'author_comment_inlude_filter' );
    }

    public function get_current_author_exclude_filter() {
        return filter_input( INPUT_GET, 'author_comment_exclude_filter' );
    }

    protected function generate_option( $value, $label, $selected = FALSE ) {
        $selected_text = "";
        if($selected)
            $selected_text  = "selected='selected'";
        return '<option ' . $selected_text . ' value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
    }

    protected function debug_on_screen($paragraph,$tag){
        echo "<$tag>$paragraph</$tag>";
    }

}

new Comments_Filters();
