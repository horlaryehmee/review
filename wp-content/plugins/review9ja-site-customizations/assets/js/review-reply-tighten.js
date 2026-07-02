(() => {
  const removeEmptyParagraphs = (scope) => {
    scope.querySelectorAll('.r9-review-replies .comment-body p').forEach((paragraph) => {
      const text = paragraph.textContent.replace(/\u00a0/g, ' ').trim();
      if (!text) {
        paragraph.remove();
      }
    });
  };

  const init = () => {
    removeEmptyParagraphs(document);

    const list = document.querySelector('.comments-list');
    if (!list || !window.MutationObserver) {
      return;
    }

    const observer = new MutationObserver(() => {
      removeEmptyParagraphs(list);
    });

    observer.observe(list, { childList: true, subtree: true });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
