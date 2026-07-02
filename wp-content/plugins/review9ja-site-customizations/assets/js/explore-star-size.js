(() => {
  const EXPLORE_SELECTOR = '#c27-explore-listings';
  const STAR_SELECTOR = 'i.mi.star, i.mi.star_half, i.mi.star_border';
  const settings = window.Review9jaExploreSettings || {};
  let addressMax = Number(settings.addressMax);
  if (!Number.isFinite(addressMax) || addressMax < 0) {
    addressMax = 20;
  }

  const rootStyles = window.getComputedStyle
    ? getComputedStyle(document.documentElement)
    : null;
  const cssStarColor = rootStyles
    ? (rootStyles.getPropertyValue('--review9ja-star-green') || '').trim()
    : '';
  const starColor = (settings.starColor || '').trim() || cssStarColor || '#16a34a';

  const sizes = {
    box: 12,
    icon: 9,
    gap: 1,
    radius: 4,
    green: starColor,
    empty: '#e5e7eb',
  };
  const CATEGORY_LIMIT = 15;

  const iconSelector =
    'i.material-icons, span.material-icons, i.mi, span.mi,' +
    ' i.fa, i.fas, i.far, i.fal, i.fab,' +
    ' i[class^="icon-"], i[class*=" icon-"], span[class^="icon-"], span[class*=" icon-"],' +
    ' svg, img';

  const applyToStar = (el) => {
    if (el.dataset.r9StarSized === '1') {
      return;
    }

    el.dataset.r9StarSized = '1';
    el.style.setProperty('width', `${sizes.box}px`, 'important');
    el.style.setProperty('height', `${sizes.box}px`, 'important');
    el.style.setProperty('min-width', `${sizes.box}px`, 'important');
    el.style.setProperty('min-height', `${sizes.box}px`, 'important');
    el.style.setProperty('display', 'inline-flex', 'important');
    el.style.setProperty('align-items', 'center', 'important');
    el.style.setProperty('justify-content', 'center', 'important');
    el.style.setProperty('border-radius', `${sizes.radius}px`, 'important');
    el.style.setProperty('font-size', `${sizes.icon}px`, 'important');
    el.style.setProperty('line-height', '1', 'important');
    el.style.setProperty('color', '#ffffff', 'important');
    el.style.setProperty('margin-right', `${sizes.gap}px`, 'important');
    el.style.setProperty('box-shadow', 'none', 'important');
    el.style.setProperty('border', '0', 'important');
    el.style.setProperty('padding', '0', 'important');
    el.style.setProperty('box-sizing', 'border-box', 'important');
    el.style.setProperty('text-align', 'center', 'important');

    if (el.classList.contains('star')) {
      el.style.setProperty('background', sizes.green, 'important');
    } else if (el.classList.contains('star_half')) {
      el.style.setProperty(
        'background',
        `linear-gradient(90deg, ${sizes.green} 50%, ${sizes.empty} 50%)`,
        'important'
      );
    } else {
      el.style.setProperty('background', sizes.empty, 'important');
    }
  };

  const applyExploreStarStyles = (root) => {
    root.querySelectorAll(STAR_SELECTOR).forEach(applyToStar);
  };

  const normalizeCategoryNames = (root) => {
    if (!root || !root.querySelectorAll) {
      return;
    }

    root.querySelectorAll('.listing-preview .category-name').forEach((el) => {
      if (el.dataset.r9CatSized === '1') {
        return;
      }

      const fullText = (el.textContent || '').replace(/\s+/g, ' ').trim();
      if (!fullText) {
        return;
      }

      if (fullText.length > CATEGORY_LIMIT) {
        el.textContent = `${fullText.slice(0, CATEGORY_LIMIT).trim()}...`;
        el.classList.remove('r9-cat-short');
        el.classList.add('r9-cat-trimmed');
        el.setAttribute('title', fullText);
      } else {
        el.textContent = fullText;
        el.classList.add('r9-cat-short');
        el.classList.remove('r9-cat-trimmed');
        el.removeAttribute('title');
      }

      el.dataset.r9CatSized = '1';
    });
  };

  const isPhoneLine = (li, text) => {
    if (li.querySelector('a[href^="tel:"]')) {
      return true;
    }
    return /^\+?[\d\s\-().]{7,}$/.test(text);
  };

  const hasLocationIcon = (li) => {
    const icon = li.querySelector('i.mi, span.mi, i.material-icons, span.material-icons');
    if (!icon) {
      return false;
    }
    const classes = icon.className || '';
    if (/(location_on|place|room|pin_drop|near_me|my_location|map)/.test(classes)) {
      return true;
    }
    return (icon.textContent || '').trim() === 'location_on';
  };

  const ensureAddressIcon = (li) => {
    let icon = li.querySelector(iconSelector);
    if (!icon) {
      const fallback = document.createElement('span');
      fallback.className = 'material-icons r9-address-icon sm-icon';
      fallback.textContent = 'location_on';
      fallback.setAttribute('aria-hidden', 'true');
      li.insertBefore(fallback, li.firstChild);
      return fallback;
    }

    icon.classList?.add('r9-address-icon');
    if (icon.classList && !icon.classList.contains('sm-icon')) {
      icon.classList.add('sm-icon');
    }
    return icon;
  };

  const normalizeAddressLine = (li) => {
    if (li.querySelector('.listing-rating')) {
      return;
    }

    let text = (li.textContent || '').replace(/\s+/g, ' ').trim();
    if (!text) {
      return;
    }

    const icon = ensureAddressIcon(li);
    const iconText = icon && icon.textContent ? icon.textContent.trim() : '';
    if (iconText && text.startsWith(iconText)) {
      text = text.slice(iconText.length).trim();
    }

    let trimmed = text;
    if (addressMax > 0 && trimmed.length > addressMax) {
      trimmed = `${trimmed.slice(0, addressMax).trim()}...`;
    }

    let textEl = li.querySelector('.r9-address-text');
    const link = li.querySelector('a[href]:not([href^="tel:"])');
    const linkHasIcon = link && link.querySelector(iconSelector);

    if (!textEl) {
      if (link) {
        if (linkHasIcon) {
          textEl = document.createElement('span');
          textEl.className = 'r9-address-text';
          link.appendChild(textEl);
        } else {
          link.classList.add('r9-address-text');
          textEl = link;
        }
      } else {
        textEl = document.createElement('span');
        textEl.className = 'r9-address-text';
        li.appendChild(textEl);
      }
    }

    textEl.textContent = trimmed;

    Array.from(li.childNodes).forEach((node) => {
      if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
        node.remove();
      }
    });

    li.classList.add('r9-address-line');
    li.classList.add('r9-address-has-icon');
    li.dataset.r9AddressLine = '1';
  };

  const tagAddressLines = (root) => {
    if (!root || !root.querySelectorAll) {
      return;
    }

    const previews = root.classList?.contains('listing-preview')
      ? [root]
      : Array.from(root.querySelectorAll('.listing-preview'));

    previews.forEach((preview) => {
      const items = Array.from(preview.querySelectorAll('.lf-contact li'));
      if (!items.length) {
        return;
      }

      const candidates = items.filter((li) => {
        if (li.querySelector('.listing-rating')) {
          return false;
        }
        const text = (li.textContent || '').replace(/\s+/g, ' ').trim();
        if (!text) {
          return false;
        }
        return !isPhoneLine(li, text);
      });

      let address = candidates.find(hasLocationIcon);
      if (!address && candidates.length) {
        address = candidates.reduce((best, li) => {
          const text = (li.textContent || '').replace(/\s+/g, ' ').trim();
          if (!best) {
            return li;
          }
          const bestText = (best.textContent || '').replace(/\s+/g, ' ').trim();
          return text.length > bestText.length ? li : best;
        }, null);
      }

      if (address) {
        normalizeAddressLine(address);
      } else {
        candidates.forEach((li) => normalizeAddressLine(li));
      }
    });
  };

  const init = () => {
    let refreshQueued = false;

    const queueRefresh = () => {
      if (refreshQueued) {
        return;
      }
      refreshQueued = true;
      requestAnimationFrame(() => {
        refreshQueued = false;
        const explore = document.querySelector(EXPLORE_SELECTOR);
        if (!explore) {
          return;
        }
        applyExploreStarStyles(explore);
        tagAddressLines(explore);
        normalizeCategoryNames(explore);
      });
    };

    const explore = document.querySelector(EXPLORE_SELECTOR);
    if (explore) {
      explore.style.setProperty('--review9ja-star-size', `${sizes.box}px`);
      explore.style.setProperty('--review9ja-star-icon-size', `${sizes.icon}px`);
      explore.style.setProperty('--review9ja-star-gap', `${sizes.gap}px`);
      explore.style.setProperty('--review9ja-star-radius', `${sizes.radius}px`);

      applyExploreStarStyles(explore);
      tagAddressLines(explore);
      normalizeCategoryNames(explore);
    }

    const bodyObserver = new MutationObserver(queueRefresh);
    bodyObserver.observe(document.body, { childList: true, subtree: true });
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
