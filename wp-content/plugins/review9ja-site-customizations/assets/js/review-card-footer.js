(() => {
  const moveFooters = () => {
    document.querySelectorAll('.comment-container.r9-review-card').forEach((card) => {
      const body = card.querySelector('.comment-body');
      const info = card.querySelector('.comment-info');
      if (!body || !info) {
        return;
      }

      if (body.contains(info)) {
        return;
      }

      const footer = document.createElement('div');
      footer.className = 'r9-review-footer';
      footer.appendChild(info);
      body.appendChild(footer);
    });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', moveFooters);
  } else {
    moveFooters();
  }
})();
