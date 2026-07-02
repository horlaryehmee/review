(() => {
  const initCommentToggle = (container) => {
    if (!container || container.classList.contains('r9-actions-ready')) {
      return;
    }

    const commentItem = container.closest('li');
    if (!commentItem) {
      return;
    }

    const depthClass = Array.from(commentItem.classList).find((name) => name.startsWith('depth-'));
    const depth = depthClass ? parseInt(depthClass.replace('depth-', ''), 10) : 0;
    if (!depth || depth < 2) {
      return;
    }

    container.classList.add('r9-deep-reply');
    container.classList.add('r9-actions-ready');

    const existingToggle = container.querySelector('.r9-reply-actions-toggle');
    if (existingToggle) {
      return;
    }

    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'r9-reply-actions-toggle';
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Toggle actions');
    toggle.innerHTML = '<i class="mi expand_more"></i>';

    const head = container.querySelector('.r9-review-head') || container.querySelector('.comment-head') || container;
    head.appendChild(toggle);

    toggle.addEventListener('click', () => {
      const open = container.classList.toggle('r9-actions-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.innerHTML = open ? '<i class="mi expand_less"></i>' : '<i class="mi expand_more"></i>';
    });
  };

  const initAll = (scope = document) => {
    scope.querySelectorAll('.comments-list li .comment-container.r9-review-card').forEach(initCommentToggle);
  };

  const onReady = () => {
    initAll();
    const list = document.querySelector('.comments-list');
    if (!list || !window.MutationObserver) {
      return;
    }

    const observer = new MutationObserver(() => {
      initAll(list);
    });

    observer.observe(list, { childList: true, subtree: true });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady);
  } else {
    onReady();
  }
})();
