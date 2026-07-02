(() => {
  const hasQueryParam = (name) => {
    const params = new URLSearchParams(window.location.search);
    return params.has(name);
  };

  const removeQueryParam = (name) => {
    try {
      const url = new URL(window.location.href);
      url.searchParams.delete(name);
      window.history.replaceState({}, '', url.toString());
    } catch (e) {
      // noop
    }
  };

  const getListingId = () => {
    const body = document.body;
    if (!body) return '0';
    for (const cls of body.classList) {
      if (cls.startsWith('postid-')) {
        return cls.replace('postid-', '') || '0';
      }
    }
    return '0';
  };

  const storageAvailable = () => {
    try {
      const key = '__r9_notice_test__';
      localStorage.setItem(key, '1');
      localStorage.removeItem(key);
      return true;
    } catch (e) {
      return false;
    }
  };

  const hideNotice = (notice, key) => {
    notice.classList.add('r9-notice-hidden');
    notice.style.display = 'none';
    if (key) {
      try {
        localStorage.setItem(key, '1');
      } catch (e) {
        // noop
      }
    }
  };

  const init = () => {
    if (!hasQueryParam('review-submitted')) {
      return;
    }

    const notice = document.querySelector('.listing-notifications .woocommerce-message');
    if (!notice) {
      return;
    }

    const listingId = getListingId();
    const userId = window.Review9jaNoticeSettings?.userId || 'guest';
    const key = `r9_review_submitted_${listingId}_${userId}`;

    if (storageAvailable()) {
      const dismissed = localStorage.getItem(key);
      if (dismissed) {
        hideNotice(notice, null);
        removeQueryParam('review-submitted');
        return;
      }
    }

    const closeBtn = notice.querySelector('.hide-notification');
    if (closeBtn) {
      closeBtn.addEventListener('click', (event) => {
        event.preventDefault();
        hideNotice(notice, key);
        removeQueryParam('review-submitted');
      });
    }

    setTimeout(() => {
      hideNotice(notice, key);
      removeQueryParam('review-submitted');
    }, 3500);
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
