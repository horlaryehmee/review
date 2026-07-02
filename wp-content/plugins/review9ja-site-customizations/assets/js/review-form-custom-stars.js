document.addEventListener('DOMContentLoaded', () => {
  const fields = document.querySelectorAll(
    '.form-group-review-ratings .rating-category-field'
  );

  fields.forEach((field) => {
    const inputs = Array.from(
      field.querySelectorAll('input[type="radio"]')
    );
    if (!inputs.length) {
      return;
    }

    const maxValue = Math.max(
      ...inputs.map((input) => parseInt(input.value, 10)).filter(Number.isFinite)
    );
    const allowHalf = inputs.some((input) => parseInt(input.value, 10) % 2 === 1);

    const ratingWrap = document.createElement('div');
    ratingWrap.className = 'r9-review-rating';
    ratingWrap.setAttribute('role', 'radiogroup');

    for (let i = 1; i <= 5; i += 1) {
      const star = document.createElement('span');
      star.className = 'r9-review-star';
      star.dataset.index = String(i);
      star.setAttribute('role', 'radio');
      star.setAttribute('tabindex', '0');
      ratingWrap.appendChild(star);
    }

    const label = field.querySelector('.rating-category-label');
    if (label && label.parentNode) {
      label.parentNode.insertBefore(ratingWrap, label.nextSibling);
    } else {
      field.appendChild(ratingWrap);
    }

    field.classList.add('r9-rating-enhanced');

    let currentValue = getCheckedValue(inputs);
    if (!Number.isFinite(currentValue)) {
      currentValue = 0;
    }

    updateStars(ratingWrap, currentValue, allowHalf);

    ratingWrap.addEventListener('mousemove', (event) => {
      const star = event.target.closest('.r9-review-star');
      if (!star) {
        return;
      }
      const hoverValue = getHoverValue(event, star, allowHalf);
      updateStars(ratingWrap, hoverValue, allowHalf);
    });

    ratingWrap.addEventListener('mouseleave', () => {
      updateStars(ratingWrap, currentValue, allowHalf);
    });

    ratingWrap.addEventListener('click', (event) => {
      const star = event.target.closest('.r9-review-star');
      if (!star) {
        return;
      }
      const newValue = getHoverValue(event, star, allowHalf);
      const matched = inputs.find(
        (input) => parseInt(input.value, 10) === newValue
      );
      if (matched) {
        matched.checked = true;
        currentValue = newValue;
        updateStars(ratingWrap, currentValue, allowHalf);
      }
    });

    ratingWrap.addEventListener('keydown', (event) => {
      if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
        return;
      }
      event.preventDefault();
      const step = allowHalf ? 1 : 2;
      const delta = event.key === 'ArrowRight' ? step : -step;
      let nextValue = currentValue + delta;
      if (nextValue < step) {
        nextValue = step;
      }
      if (nextValue > maxValue) {
        nextValue = maxValue;
      }
      const matched = inputs.find(
        (input) => parseInt(input.value, 10) === nextValue
      );
      if (matched) {
        matched.checked = true;
        currentValue = nextValue;
        updateStars(ratingWrap, currentValue, allowHalf);
      }
    });
  });
});

function getCheckedValue(inputs) {
  const checked = inputs.find((input) => input.checked);
  if (!checked) {
    return 0;
  }
  const value = parseInt(checked.value, 10);
  return Number.isFinite(value) ? value : 0;
}

function getHoverValue(event, star, allowHalf) {
  const index = parseInt(star.dataset.index, 10);
  if (!allowHalf || !Number.isFinite(index)) {
    return index * 2;
  }
  const rect = star.getBoundingClientRect();
  const isLeft = event.clientX - rect.left < rect.width / 2;
  return isLeft ? index * 2 - 1 : index * 2;
}

function updateStars(wrapper, value, allowHalf) {
  const stars = wrapper.querySelectorAll('.r9-review-star');
  const maxFull = Math.floor(value / 2);
  const hasHalf = allowHalf && value % 2 === 1;

  stars.forEach((star, idx) => {
    const index = idx + 1;
    star.classList.remove('is-full', 'is-half');
    if (index <= maxFull) {
      star.classList.add('is-full');
    } else if (index === maxFull + 1 && hasHalf) {
      star.classList.add('is-half');
    }
    star.setAttribute('aria-checked', index <= maxFull || (index === maxFull + 1 && hasHalf));
  });
}
