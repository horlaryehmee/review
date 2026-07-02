(function () {
  function pad(value) {
    return value.toString().padStart(2, '0');
  }

  function updateCountdown(container) {
    var targetValue = container.getAttribute('data-countdown');
    if (!targetValue) {
      return;
    }

    var targetDate = new Date(targetValue);
    if (isNaN(targetDate.getTime())) {
      return;
    }

    var daysEl = container.querySelector('[data-unit="days"]');
    var hoursEl = container.querySelector('[data-unit="hours"]');
    var minsEl = container.querySelector('[data-unit="mins"]');
    var secsEl = container.querySelector('[data-unit="secs"]');

    function tick() {
      var now = new Date();
      var diff = targetDate.getTime() - now.getTime();
      if (diff < 0) {
        diff = 0;
      }

      var totalSeconds = Math.floor(diff / 1000);
      var days = Math.floor(totalSeconds / 86400);
      totalSeconds -= days * 86400;
      var hours = Math.floor(totalSeconds / 3600);
      totalSeconds -= hours * 3600;
      var mins = Math.floor(totalSeconds / 60);
      var secs = totalSeconds - mins * 60;

      if (daysEl) {
        daysEl.textContent = pad(days);
      }
      if (hoursEl) {
        hoursEl.textContent = pad(hours);
      }
      if (minsEl) {
        minsEl.textContent = pad(mins);
      }
      if (secsEl) {
        secsEl.textContent = pad(secs);
      }
    }

    tick();
    setInterval(tick, 1000);
  }

  document.addEventListener('DOMContentLoaded', function () {
    var container = document.querySelector('.bakhtech-cs-countdown');
    if (container) {
      updateCountdown(container);
    }
  });
})();
