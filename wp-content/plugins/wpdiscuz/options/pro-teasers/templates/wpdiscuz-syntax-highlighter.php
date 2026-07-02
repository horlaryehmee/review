<?php

if (!defined("ABSPATH")) {
    exit();
}

$wshStyles = [
    "default"                    => "Default",
    "a11y-dark"                  => "A 11 Y Dark",
    "a11y-light"                 => "A 11 Y Light",
    "agate"                      => "Agate",
    "androidstudio"              => "Androidstudio",
    "an-old-hope"                => "An Old Hope",
    "arduino-light"              => "Arduino Light",
    "arta"                       => "Arta",
    "ascetic"                    => "Ascetic",
    "atelier-cave-dark"          => "Atelier Cave Dark",
    "atelier-cave-light"         => "Atelier Cave Light",
    "atelier-dune-dark"          => "Atelier Dune Dark",
    "atelier-dune-light"         => "Atelier Dune Light",
    "atelier-estuary-dark"       => "Atelier Estuary Dark",
    "atelier-estuary-light"      => "Atelier Estuary Light",
    "atelier-forest-dark"        => "Atelier Forest Dark",
    "atelier-forest-light"       => "Atelier Forest Light",
    "atelier-heath-dark"         => "Atelier Heath Dark",
    "atelier-heath-light"        => "Atelier Heath Light",
    "atelier-lakeside-dark"      => "Atelier Lakeside Dark",
    "atelier-lakeside-light"     => "Atelier Lakeside Light",
    "atelier-plateau-dark"       => "Atelier Plateau Dark",
    "atelier-plateau-light"      => "Atelier Plateau Light",
    "atelier-savanna-dark"       => "Atelier Savanna Dark",
    "atelier-savanna-light"      => "Atelier Savanna Light",
    "atelier-seaside-dark"       => "Atelier Seaside Dark",
    "atelier-seaside-light"      => "Atelier Seaside Light",
    "atelier-sulphurpool-dark"   => "Atelier Sulphurpool Dark",
    "atelier-sulphurpool-light"  => "Atelier Sulphurpool Light",
    "atom-one-dark"              => "Atom One Dark",
    "atom-one-dark-reasonable"   => "Atom One Dark Reasonable",
    "atom-one-light"             => "Atom One Light",
    "brown-paper"                => "Brown Paper",
    "codepen-embed"              => "Codepen Embed",
    "color-brewer"               => "Color Brewer",
    "darcula"                    => "Darcula",
    "dark"                       => "Dark",
    "darkula"                    => "Darkula",
    "docco"                      => "Docco",
    "dracula"                    => "Dracula",
    "far"                        => "Far",
    "foundation"                 => "Foundation",
    "github-gist"                => "Github Gist",
    "github"                     => "Github",
    "gml"                        => "Gml",
    "googlecode"                 => "Googlecode",
    "grayscale"                  => "Grayscale",
    "gruvbox-dark"               => "Gruvbox Dark",
    "gruvbox-light"              => "Gruvbox Light",
    "hopscotch"                  => "Hopscotch",
    "hybrid"                     => "Hybrid",
    "idea"                       => "Idea",
    "ir-black"                   => "Ir Black",
    "isbl-editor-dark"           => "Isbl Editor Dark",
    "isbl-editor-light"          => "Isbl Editor Light",
    "kimbie.dark"                => "Kimbie Dark",
    "kimbie.light"               => "Kimbie Light",
    "lightfair"                  => "Lightfair",
    "magula"                     => "Magula",
    "mono-blue"                  => "Mono Blue",
    "monokai"                    => "Monokai",
    "monokai-sublime"            => "Monokai Sublime",
    "nord"                       => "Nord",
    "obsidian"                   => "Obsidian",
    "ocean"                      => "Ocean",
    "paraiso-dark"               => "Paraiso Dark",
    "paraiso-light"              => "Paraiso Light",
    "pojoaque"                   => "Pojoaque",
    "purebasic"                  => "Purebasic",
    "qtcreator_dark"             => "Qtcreator Dark",
    "qtcreator_light"            => "Qtcreator Light",
    "railscasts"                 => "Railscasts",
    "rainbow"                    => "Rainbow",
    "routeros"                   => "Routeros",
    "school-book"                => "School Book",
    "shades-of-purple"           => "Shades Of Purple",
    "solarized-dark"             => "Solarized Dark",
    "solarized-light"            => "Solarized Light",
    "sunburst"                   => "Sunburst",
    "tomorrow"                   => "Tomorrow",
    "tomorrow-night"             => "Tomorrow Night",
    "tomorrow-night-blue"        => "Tomorrow Night Blue",
    "tomorrow-night-bright"      => "Tomorrow Night Bright",
    "tomorrow-night-eighties"    => "Tomorrow Night Eighties",
    "vs"                         => "Vs",
    "vs2015"                     => "Vs 2015",
    "xcode"                      => "Xcode",
    "xt256"                      => "Xt 256",
    "zenburn"                    => "Zenburn",
];

$wshSmallPack = [
    "apache"       => "Apache",
    "bash"         => "Bash",
    "cs"           => "C#",
    "cpp"          => "C++",
    "css"          => "CSS",
    "coffeescript" => "CoffeeScript",
    "diff"         => "Diff",
    "xml"          => "HTML, XML",
    "http"         => "HTTP",
    "ini"          => "Ini, TOML",
    "json"         => "JSON",
    "java"         => "Java",
    "javascript"   => "JavaScript",
    "makefile"     => "Makefile",
    "markdown"     => "Markdown",
    "nginx"        => "Nginx",
    "objectivec"   => "Objective-C",
    "php"          => "PHP",
    "perl"         => "Perl",
    "properties"   => "Properties",
    "python"       => "Python",
    "ruby"         => "Ruby",
    "sql"          => "SQL",
    "shell"        => "Shell Session",
];

$wshMiddlePack = [
    "armasm"         => "ARM Assembly",
    "avrasm"         => "AVR Assembler",
    "ada"            => "Ada",
    "awk"            => "Awk",
    "arduino"        => "Arduino",
    "basic"          => "Basic",
    "cal"            => "C/AL",
    "clojure"        => "Clojure",
    "d"              => "D",
    "dart"           => "Dart",
    "delphi"         => "Delphi",
    "erlang"         => "Erlang",
    "fsharp"         => "F#",
    "fortran"        => "Fortran",
    "go"             => "Go",
    "groovy"         => "Groovy",
    "haskell"        => "Haskell",
    "julia"          => "Julia",
    "kotlin"         => "Kotlin",
    "lisp"           => "Lisp",
    "livecodeserver" => "LiveCode",
    "livescript"     => "LiveScript",
    "lua"            => "Lua",
    "mips"           => "MIPS Assembly",
    "mathematica"    => "Mathematica",
    "matlab"         => "Matlab",
    "postgres"       => "PostgreSQL SQL dialect and PL/pgSQL",
    "prolog"         => "Prolog",
    "r"              => "R",
    "rust"           => "Rust",
    "sas"            => "SAS",
    "scala"          => "Scala",
    "scheme"         => "Scheme",
    "swift"          => "Swift",
    "typescript"     => "TypeScript",
    "vbnet"          => "VB.NET",
    "verilog"        => "Verilog",
];

$wshFullPack = [
    "1c"            => "1C:Enterprise (v7, v8)",
    "accesslog"     => "Access log",
    "actionscript"  => "ActionScript",
    "asc"           => "AngelScript",
    "applescript"   => "AppleScript",
    "arcade"        => "ArcGIS Arcade",
    "asciidoc"      => "AsciiDoc",
    "aspectj"       => "AspectJ",
    "abnf"          => "Augmented Backus-Naur Form",
    "autohotkey"    => "AutoHotkey",
    "autoit"        => "AutoIt",
    "axapta"        => "Axapta",
    "bnf"           => "Backus\u{2013}Naur Form",
    "brainfuck"     => "Brainfuck",
    "cmake"         => "CMake",
    "csp"           => "CSP",
    "cos"           => "Cach\u{00E9} Object Script",
    "capnproto"     => "Cap'n Proto",
    "ceylon"        => "Ceylon",
    "clean"         => "Clean",
    "clojure-repl"  => "Clojure REPL",
    "coq"           => "Coq",
    "crystal"       => "Crystal",
    "crmsh"         => "Crmsh",
    "dns"           => "DNS Zone file",
    "dos"           => "DOS .bat",
    "dts"           => "Device Tree",
    "django"        => "Django",
    "dockerfile"    => "Dockerfile",
    "dust"          => "Dust",
    "dsconfig"      => "dsconfig",
    "erb"           => "ERB (Embedded Ruby)",
    "elixir"        => "Elixir",
    "elm"           => "Elm",
    "erlang-repl"   => "Erlang REPL",
    "excel"         => "Excel",
    "ebnf"          => "Extended Backus-Naur Form",
    "fix"           => "FIX",
    "flix"          => "Flix",
    "nc"            => "G-code (ISO 6983)",
    "gams"          => "GAMS",
    "gauss"         => "GAUSS",
    "glsl"          => "GLSL",
    "gml"           => "GML",
    "feature"       => "Gherkin",
    "golo"          => "Golo",
    "gradle"        => "Gradle",
    "hsp"           => "HSP",
    "htmlbars"      => "HTMLBars",
    "haml"          => "Haml",
    "handlebars"    => "Handlebars",
    "haxe"          => "Haxe",
    "hy"            => "Hy",
    "irpf90"        => "IRPF90",
    "isbl"          => "ISBL",
    "inform7"       => "Inform 7",
    "x86asm"        => "Intel x86 Assembly",
    "julia-repl"    => "Julia REPL",
    "wildfly-cli"   => "jboss-cli",
    "ldif"          => "LDIF",
    "llvm"          => "LLVM IR",
    "lasso"         => "Lasso",
    "leaf"          => "Leaf",
    "less"          => "Less",
    "lsl"           => "Linden Scripting Language",
    "mel"           => "MEL(Maya Embedded Language)",
    "maxima"        => "Maxima",
    "mercury"       => "Mercury",
    "routeros"      => "Microtik RouterOS script",
    "mizar"         => "Mizar",
    "mojolicious"   => "Mojolicious",
    "monkey"        => "Monkey",
    "moonscript"    => "MoonScript",
    "n1ql"          => "N1QL",
    "nsis"          => "NSIS",
    "nimrod"        => "Nimrod",
    "nix"           => "Nix",
    "ocaml"         => "OCaml",
    "ruleslanguage" => "Oracle Rules Language",
    "oxygene"       => "Oxygene",
    "parser3"       => "Parser3",
    "pony"          => "Pony",
    "powershell"    => "PowerShell",
    "processing"    => "Processing",
    "protobuf"      => "Protocol Buffers",
    "puppet"        => "Puppet",
    "purebasic"     => "PureBASIC",
    "profile"       => "Python profile",
    "pf"            => "PF",
    "plaintext"     => "Plain Text",
    "kdb"           => "Q",
    "qml"           => "QML",
    "re"            => "ReasonML",
    "rib"           => "RenderMan RIB",
    "rsl"           => "RenderMan RSL",
    "graph"         => "Roboconf",
    "scss"          => "SCSS",
    "ml"            => "SML",
    "sqf"           => "SQF",
    "p21"           => "STEP Part 21",
    "scilab"        => "Scilab",
    "smali"         => "Smali",
    "smalltalk"     => "Smalltalk",
    "stan"          => "Stan",
    "stata"         => "Stata",
    "stylus"        => "Stylus",
    "subunit"       => "SubUnit",
    "tp"            => "TP",
    "taggerscript"  => "Tagger Script",
    "tcl"           => "Tcl",
    "tex"           => "TeX",
    "tap"           => "Test Anything Protocol",
    "thrift"        => "Thrift",
    "twig"          => "Twig",
    "vbscript"      => "VBScript",
    "vbscript-html" => "VBScript in HTML",
    "vhdl"          => "VHDL",
    "vala"          => "Vala",
    "vim"           => "Vim Script",
    "xl"            => "XL",
    "xpath"         => "XQuery",
    "yaml"          => "YAML",
    "zephir"        => "Zephir",
];

?>
<div class="wpd-pro-teaser-wrap">

    <div class="wpd-pro-teaser-header">
        <span class="wpd-pro-teaser-title">
            <span class="dashicons dashicons-editor-code"></span>
            <?php esc_html_e("Syntax Highlighter Addon Settings", "wpdiscuz"); ?>
            <span class="wpd-pro-badge"><?php esc_html_e("PRO", "wpdiscuz"); ?></span>
        </span>
        <span class="wpd-pro-teaser-header-right">
            <span class="wpd-pro-toggle-icon">&#9650;</span>
        </span>
    </div>

    <div class="wpd-pro-teaser-body">

        <!-- Intro -->
        <div class="wpd-opt-row">
            <div class="wpd-opt-intro">
                <?php esc_html_e("Syntax highlighting for comments, automatic language detection and multi-language code highlighting. Uses highlight.js with a wide selection of themes and language packs.", "wpdiscuz"); ?>
            </div>
        </div>

        <div class="wpd-subtitle"><?php esc_html_e("General", "wpdiscuz"); ?></div>

        <!-- Option start: wpd_syntax_style -->
        <div class="wpd-opt-row" data-wpd-opt="wpd_syntax_style">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Style", "wpdiscuz"); ?></label>
                <p class="wpd-desc">
                    <?php esc_html_e("Plugin wpDiscuz Syntax Highlighter uses highlight.js javascript library.", "wpdiscuz"); ?>
                    <a href="https://highlightjs.org/static/demo/" target="_blank" rel="noopener noreferrer"><?php esc_html_e("Styles demo", "wpdiscuz"); ?></a>
                </p>
            </div>
            <div class="wpd-opt-input">
                <select>
                    <?php foreach ($wshStyles as $key => $label) : ?>
                        <option value="<?php echo esc_attr($key); ?>"<?php echo $key === "default" ? " selected" : ""; ?>><?php echo esc_html($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpd_syntax_package -->
        <div class="wpd-opt-row" data-wpd-opt="wpd_syntax_package">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Language Packs", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <div class="wpd-switch-field">
                    <input type="radio" disabled value="small" checked id="wsh-pro-pkg-small"/>
                    <label for="wsh-pro-pkg-small" class="wpd-radio-lbl"><?php esc_html_e("Common", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="middle" id="wsh-pro-pkg-middle"/>
                    <label for="wsh-pro-pkg-middle" class="wpd-radio-lbl"><?php esc_html_e("Middle", "wpdiscuz"); ?></label>
                    <input type="radio" disabled value="full" id="wsh-pro-pkg-full"/>
                    <label for="wsh-pro-pkg-full" class="wpd-radio-lbl"><?php esc_html_e("Full", "wpdiscuz"); ?></label>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpd_syntax_customselector -->
        <div class="wpd-opt-row" data-wpd-opt="wpd_syntax_customselector">
            <div class="wpd-opt-name">
                <label><?php esc_html_e("Custom Selector", "wpdiscuz"); ?></label>
            </div>
            <div class="wpd-opt-input">
                <input type="text" disabled value="" class="wpd-teaser-input"/>
            </div>
        </div>
        <!-- Option end -->

        <div class="wpd-subtitle"><?php esc_html_e("Languages", "wpdiscuz"); ?></div>

        <!-- Option start: wpd_syntax_lang_small -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="wpd_syntax_lang_small">
            <div class="wpd-opt-input wpd-opt-input-full-row">
                <h2 class="wsh-pro-lang-h2"><?php esc_html_e("Common", "wpdiscuz"); ?></h2>
                <hr/>
                <div class="wpd-multi-check wsh-pro-multi-check">
                    <?php foreach ($wshSmallPack as $key => $label) : ?>
                    <div class="wpd-mublock-inline">
                        <input type="checkbox" disabled value="<?php echo esc_attr($key); ?>" id="wsh-pro-lang-<?php echo esc_attr($key); ?>" checked/>
                        <label for="wsh-pro-lang-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
                    </div>
                    <?php endforeach; ?>
                    <div class="wpd-clear"></div>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpd_syntax_lang_middle -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="wpd_syntax_lang_middle">
            <div class="wpd-opt-input wpd-opt-input-full-row">
                <h2 class="wsh-pro-lang-h2"><?php esc_html_e("Middle", "wpdiscuz"); ?></h2>
                <hr/>
                <div class="wpd-multi-check wsh-pro-multi-check">
                    <?php foreach ($wshMiddlePack as $key => $label) : ?>
                    <div class="wpd-mublock-inline">
                        <input type="checkbox" disabled value="<?php echo esc_attr($key); ?>" id="wsh-pro-lang-<?php echo esc_attr($key); ?>"/>
                        <label for="wsh-pro-lang-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
                    </div>
                    <?php endforeach; ?>
                    <div class="wpd-clear"></div>
                </div>
            </div>
        </div>
        <!-- Option end -->

        <!-- Option start: wpd_syntax_lang_full -->
        <div class="wpd-opt-row wpd-opt-row-no-border" data-wpd-opt="wpd_syntax_lang_full">
            <div class="wpd-opt-input wpd-opt-input-full-row">
                <h2 class="wsh-pro-lang-h2"><?php esc_html_e("Full", "wpdiscuz"); ?></h2>
                <hr/>
                <div class="wpd-multi-check wsh-pro-multi-check">
                    <?php foreach ($wshFullPack as $key => $label) : ?>
                    <div class="wpd-mublock-inline">
                        <input type="checkbox" disabled value="<?php echo esc_attr($key); ?>" id="wsh-pro-lang-<?php echo esc_attr($key); ?>"/>
                        <label for="wsh-pro-lang-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
                    </div>
                    <?php endforeach; ?>
                    <div class="wpd-clear"></div>
                </div>
            </div>
        </div>
        <!-- Option end -->

    </div><!-- /.wpd-pro-teaser-body -->

    <div class="wpd-pro-teaser-cta">
        <a href="https://gvectors.com/product/wpdiscuz-syntax-highlighter/" target="_blank" rel="noopener noreferrer" class="button button-primary">
            <?php esc_html_e("Get Syntax Highlighter Addon", "wpdiscuz"); ?> &rarr;
        </a>
    </div>

</div><!-- /.wpd-pro-teaser-wrap -->
