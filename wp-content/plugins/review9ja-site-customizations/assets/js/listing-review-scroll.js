(() => {
  const TRIGGERS = '.show-review-form, .c27-add-listing-review, .pa-below-title .listing-rating';
  const COMMENTS_TAB_SELECTOR = '.listing-tab-toggle.toggle-tab-type-comments';

  const getTarget = () =>
    document.querySelector('#commentform') ||
    document.querySelector('.sidebar-comment-form') ||
    document.querySelector('.comments-list-wrapper');

  const scrollToTarget = (target) => {
    if (!target) {
      return;
    }
    const rect = target.getBoundingClientRect();
    const offset = 80;
    const top = window.pageYOffset + rect.top - offset;
    window.scrollTo({ top, behavior: 'smooth' });
  };

  const focusReviewForm = () => {
    let attempts = 0;
    const maxAttempts = 12;
    const timer = setInterval(() => {
      attempts += 1;
      const target = getTarget();
      if (target) {
        clearInterval(timer);
        scrollToTarget(target);
        const textarea = target.querySelector('textarea[name="comment"]');
        if (textarea) {
          setTimeout(() => textarea.focus({ preventScroll: true }), 200);
        }
      } else if (attempts >= maxAttempts) {
        clearInterval(timer);
      }
    }, 250);
  };

  const handleClick = (event) => {
    const trigger = event.target.closest(TRIGGERS);
    if (!trigger) {
      return;
    }

    event.preventDefault();

    const tabToggle = document.querySelector(COMMENTS_TAB_SELECTOR);
    if (tabToggle) {
      tabToggle.click();
    }

    focusReviewForm();
  };

  document.addEventListener('click', handleClick);
})();
