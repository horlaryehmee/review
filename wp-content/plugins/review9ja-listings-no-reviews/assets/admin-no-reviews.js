(() => {
  const settings = window.Review9jaNoReviewsSettings || {};
  const container = document.querySelector(".review9ja-no-reviews");
  if (!container || !settings.ajaxUrl) {
    return;
  }

  const mode = container.dataset.mode || "no-reviews";
  const rowsEl = container.querySelector("[data-role='rows']");
  const paginationEl = container.querySelector("[data-role='pagination']");
  const countEl = container.querySelector("[data-role='count']");
  const filtersForm = container.querySelector("[data-action='filters']");
  const reloadBtn = container.querySelector("[data-action='reload']");
  const sortSelect = container.querySelector("#r9-sort");
  const perPageInput = container.querySelector("#r9-per-page");

  let currentPage = 1;
  let loadingCount = 0;

  const actionMap = {
    "no-reviews": "review9ja_no_reviews_list",
    "hidden": "review9ja_hidden_list"
  };

  function updateLoadingState() {
    container.classList.toggle("r9-loading", loadingCount > 0);
  }

  function startLoading() {
    loadingCount += 1;
    updateLoadingState();
  }

  function stopLoading() {
    loadingCount = Math.max(0, loadingCount - 1);
    updateLoadingState();
  }

  function updateCount(total) {
    if (countEl) {
      countEl.textContent = total.toLocaleString();
    }
  }

  function updateRows(html) {
    if (rowsEl) {
      rowsEl.innerHTML = html;
    }
  }

  function updatePagination(html) {
    if (paginationEl) {
      paginationEl.innerHTML = html || "";
    }
  }

  function fetchList(page = 1, options = {}) {
    const force = options.force === true;
    if (!force && loadingCount > 0) {
      return;
    }

    currentPage = page;
    startLoading();

    const formData = new URLSearchParams();
    formData.append("action", actionMap[mode] || actionMap["no-reviews"]);
    formData.append("nonce", settings.nonce || "");
    formData.append("page", String(currentPage));
    if (sortSelect) {
      formData.append("sort", sortSelect.value || "az");
    }
    if (perPageInput) {
      formData.append("per_page", perPageInput.value || "");
    }

    fetch(settings.ajaxUrl, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
      body: formData.toString()
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data || !data.success) {
          throw new Error((data && data.data && data.data.message) || "Request failed");
        }
        updateRows(data.data.rows || "");
        updatePagination(data.data.pagination || "");
        updateCount(data.data.total || 0);
      })
      .catch(() => {
        updateRows(
          "<tr><td colspan='5' class='r9-empty'>Unable to load listings. Please try again.</td></tr>"
        );
        updatePagination("");
      })
      .finally(() => stopLoading());
  }

  function handlePaginationClick(event) {
    const target = event.target;
    if (!(target instanceof HTMLElement)) {
      return;
    }
    if (!target.classList.contains("page-numbers")) {
      return;
    }
    const page = target.dataset.page;
    if (!page) {
      return;
    }
    event.preventDefault();
    fetchList(parseInt(page, 10));
  }

  function handleRowAction(event) {
    const target = event.target;
    if (!(target instanceof HTMLElement)) {
      return;
    }
    if (!target.classList.contains("r9-action")) {
      return;
    }

    const listingId = target.dataset.id;
    const action = target.dataset.action;
    if (!listingId || !action) {
      return;
    }

    const confirmText =
      action === "hide"
        ? "Hide this listing from the site?"
        : "Restore this listing to the site?";

    if (!window.confirm(confirmText)) {
      return;
    }

    const formData = new URLSearchParams();
    formData.append("action", action === "hide" ? "review9ja_hide_listing" : "review9ja_unhide_listing");
    formData.append("nonce", settings.nonce || "");
    formData.append("listing_id", listingId);

    if (loadingCount > 0) {
      return;
    }

    startLoading();
    fetch(settings.ajaxUrl, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
      body: formData.toString()
    })
      .then((response) => response.json())
      .then((data) => {
        if (!data || !data.success) {
          throw new Error((data && data.data && data.data.message) || "Request failed");
        }
        fetchList(currentPage, { force: true });
      })
      .catch(() => {
        alert("Action failed. Please try again.");
      })
      .finally(() => stopLoading());
  }

  function clampPerPage() {
    if (!perPageInput) {
      return;
    }
    const max = Number(settings.maxPerPage || 100);
    let value = parseInt(perPageInput.value || "0", 10);
    if (!value || value < 1) {
      value = 1;
    }
    if (value > max) {
      value = max;
    }
    perPageInput.value = String(value);
  }

  if (filtersForm) {
    filtersForm.addEventListener("submit", (event) => {
      event.preventDefault();
      clampPerPage();
      fetchList(1, { force: true });
    });
  }

  if (reloadBtn) {
    reloadBtn.addEventListener("click", () => fetchList(currentPage, { force: true }));
  }

  if (perPageInput) {
    perPageInput.addEventListener("blur", clampPerPage);
    perPageInput.addEventListener("change", clampPerPage);
  }

  if (paginationEl) {
    paginationEl.addEventListener("click", handlePaginationClick);
  }

  if (rowsEl) {
    rowsEl.addEventListener("click", handleRowAction);
  }

  fetchList(1, { force: true });
})();
