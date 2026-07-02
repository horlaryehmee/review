(() => {
  const init = () => {
    const header = document.querySelector('.profile-header');
    if (!header) {
      return;
    }

    const menu = header.querySelector('.profile-menu');
    const ul = menu ? menu.querySelector('ul') : null;
    if (!ul) {
      return;
    }

    header.classList.add('r9-tabs-full');
    if (menu) {
      menu.classList.add('r9-tabs-full');
    }

    ul.classList.remove('cts-carousel');
    ul.classList.add('r9-tabs-full');

    ul.querySelectorAll('.cts-prev, .cts-next').forEach((el) => el.remove());
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
