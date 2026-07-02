(function () {
    "use strict";

    var config = window.review9jaReviewShare || {};
    var labels = Object.assign(
        {
            dialogTitle: "Social Media Preview",
            dialogDescription: "Choose a format and download a shareable PNG.",
            download: "Download High-Res PNG",
            formatLabel: "Formats",
            formatPortrait: "4:5 Portrait",
            formatSquare: "1:1 Square",
            formatStory: "9:16 Story",
            formatLandscape: "16:9 Landscape",
            presetLabel: "Presets",
            close: "Close preview",
            verified: "Verified Reviewer",
            customerReview: "Customer Review",
            topRated: "Top Rated Business",
            fallbackLocation: "Nigeria"
        },
        config.labels || {}
    );

    var PRESETS = [
        {
            id: "cobalt",
            name: "Cobalt",
            accent: "#0f5bd7",
            accentDark: "#0a47ad",
            backgroundStart: "#edf4ff",
            backgroundEnd: "#d7e5fb",
            orbOne: "rgba(15, 91, 215, 0.20)",
            orbTwo: "rgba(59, 130, 246, 0.18)",
            card: "#ffffff",
            cardBorder: "rgba(255, 255, 255, 0.88)",
            text: "#0f172a",
            muted: "#64748b",
            chipFill: "rgba(15, 91, 215, 0.12)",
            chipText: "#0f5bd7",
            star: "#12b981",
            starTrack: "#cbd5e1",
            avatarFill: "#dbeafe",
            avatarText: "#0f5bd7",
            quoteTint: "rgba(15, 91, 215, 0.12)"
        },
        {
            id: "emerald",
            name: "Emerald",
            accent: "#0f9f6e",
            accentDark: "#0b7e57",
            backgroundStart: "#eefbf4",
            backgroundEnd: "#d8f4e6",
            orbOne: "rgba(16, 185, 129, 0.18)",
            orbTwo: "rgba(5, 150, 105, 0.16)",
            card: "#ffffff",
            cardBorder: "rgba(255, 255, 255, 0.88)",
            text: "#102a23",
            muted: "#557168",
            chipFill: "rgba(15, 159, 110, 0.12)",
            chipText: "#0f9f6e",
            star: "#10b981",
            starTrack: "#cfe7dc",
            avatarFill: "#d8f7ea",
            avatarText: "#0f9f6e",
            quoteTint: "rgba(15, 159, 110, 0.12)"
        },
        {
            id: "midnight",
            name: "Midnight",
            accent: "#10182d",
            accentDark: "#050a18",
            backgroundStart: "#e7ecf7",
            backgroundEnd: "#cdd7ea",
            orbOne: "rgba(15, 23, 42, 0.20)",
            orbTwo: "rgba(30, 41, 59, 0.16)",
            card: "#ffffff",
            cardBorder: "rgba(255, 255, 255, 0.92)",
            text: "#0f172a",
            muted: "#667085",
            chipFill: "rgba(15, 23, 42, 0.10)",
            chipText: "#0f172a",
            star: "#ef476f",
            starTrack: "#d3dae6",
            avatarFill: "#e2e8f0",
            avatarText: "#0f172a",
            quoteTint: "rgba(15, 23, 42, 0.10)"
        },
        {
            id: "coral",
            name: "Coral",
            accent: "#e95454",
            accentDark: "#c93c3c",
            backgroundStart: "#fff1ef",
            backgroundEnd: "#fde0da",
            orbOne: "rgba(233, 84, 84, 0.18)",
            orbTwo: "rgba(244, 114, 114, 0.16)",
            card: "#ffffff",
            cardBorder: "rgba(255, 255, 255, 0.88)",
            text: "#1f2937",
            muted: "#6b7280",
            chipFill: "rgba(233, 84, 84, 0.12)",
            chipText: "#d63a3a",
            star: "#f59e0b",
            starTrack: "#e8d8cb",
            avatarFill: "#ffe4e1",
            avatarText: "#cc3f3f",
            quoteTint: "rgba(233, 84, 84, 0.10)"
        }
    ];

    var FORMATS = [
        {
            id: "portrait",
            name: labels.formatPortrait,
            width: 1080,
            height: 1350
        },
        {
            id: "square",
            name: labels.formatSquare,
            width: 1080,
            height: 1080
        },
        {
            id: "story",
            name: labels.formatStory,
            width: 1080,
            height: 1920
        },
        {
            id: "landscape",
            name: labels.formatLandscape,
            width: 1200,
            height: 675
        }
    ];

    var FILLED_STAR = String.fromCharCode(9733);
    var EMPTY_STAR = String.fromCharCode(9734);

    function normalizeWhitespace(value) {
        return String(value || "").replace(/\s+/g, " ").trim();
    }

    function slugify(value) {
        return normalizeWhitespace(value)
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    }

    function loadImage(url) {
        return new Promise(function (resolve, reject) {
            var image;

            if (!url) {
                resolve(null);
                return;
            }

            image = new Image();
            image.decoding = "async";
            image.crossOrigin = "anonymous";
            image.onload = function () {
                resolve(image);
            };
            image.onerror = reject;
            image.src = url;

            if (image.complete && image.naturalWidth) {
                resolve(image);
            }
        });
    }

    function roundRectPath(ctx, x, y, width, height, radius) {
        var r = Math.min(radius, width / 2, height / 2);

        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + width - r, y);
        ctx.quadraticCurveTo(x + width, y, x + width, y + r);
        ctx.lineTo(x + width, y + height - r);
        ctx.quadraticCurveTo(x + width, y + height, x + width - r, y + height);
        ctx.lineTo(x + r, y + height);
        ctx.quadraticCurveTo(x, y + height, x, y + height - r);
        ctx.lineTo(x, y + r);
        ctx.quadraticCurveTo(x, y, x + r, y);
        ctx.closePath();
    }

    function fillRoundedRect(ctx, x, y, width, height, radius, fillStyle) {
        roundRectPath(ctx, x, y, width, height, radius);
        ctx.fillStyle = fillStyle;
        ctx.fill();
    }

    function strokeRoundedRect(ctx, x, y, width, height, radius, strokeStyle, lineWidth) {
        roundRectPath(ctx, x, y, width, height, radius);
        ctx.strokeStyle = strokeStyle;
        ctx.lineWidth = lineWidth;
        ctx.stroke();
    }

    function getContainedImageSize(imageWidth, imageHeight, maxWidth, maxHeight) {
        var ratio = Math.min(maxWidth / imageWidth, maxHeight / imageHeight);

        return {
            width: imageWidth * ratio,
            height: imageHeight * ratio
        };
    }

    function fitTextSingleLine(ctx, text, maxWidth) {
        var value = normalizeWhitespace(text);

        if (value === "") {
            return "";
        }

        if (ctx.measureText(value).width <= maxWidth) {
            return value;
        }

        var shortened = value;
        while (shortened.length > 0 && ctx.measureText(shortened + "...").width > maxWidth) {
            shortened = shortened.slice(0, -1);
        }

        return shortened ? shortened + "..." : "...";
    }

    function wrapText(ctx, text, maxWidth, maxLines) {
        return wrapTextDetailed(ctx, text, maxWidth, maxLines).lines;
    }

    function wrapTextDetailed(ctx, text, maxWidth, maxLines) {
        var words = normalizeWhitespace(text).split(" ");
        var lines = [];
        var currentLine = "";
        var i;
        var truncated = false;

        if (!words[0]) {
            return {
                lines: lines,
                truncated: false
            };
        }

        for (i = 0; i < words.length; i += 1) {
            var testLine = currentLine ? currentLine + " " + words[i] : words[i];
            var testWidth = ctx.measureText(testLine).width;

            if (testWidth <= maxWidth) {
                currentLine = testLine;
                continue;
            }

            if (currentLine) {
                lines.push(currentLine);
                currentLine = words[i];
            } else {
                lines.push(fitTextSingleLine(ctx, words[i], maxWidth));
                currentLine = "";
            }

            if (lines.length === maxLines) {
                truncated = true;
                break;
            }
        }

        if (lines.length < maxLines && currentLine) {
            lines.push(currentLine);
        }

        if (truncated && lines.length) {
            lines[lines.length - 1] = fitTextSingleLine(ctx, lines[lines.length - 1], maxWidth);

            if (!/\.\.\.$/.test(lines[lines.length - 1])) {
                lines[lines.length - 1] = fitTextSingleLine(ctx, lines[lines.length - 1] + "...", maxWidth);
            }
        }

        return {
            lines: lines.slice(0, maxLines),
            truncated: truncated
        };
    }

    function drawTextLines(ctx, lines, x, y, lineHeight, fillStyle) {
        var index;

        ctx.fillStyle = fillStyle;
        for (index = 0; index < lines.length; index += 1) {
            ctx.fillText(lines[index], x, y + (index * lineHeight));
        }

        return y + (Math.max(lines.length - 1, 0) * lineHeight);
    }

    function buildFont(weight, size, family) {
        return weight + " " + size + "px " + family;
    }

    function resolveTextLayout(ctx, text, maxWidth, maxHeight, options) {
        var maxSize = options.maxSize;
        var minSize = options.minSize;
        var step = options.step || 1;
        var lineHeightMultiplier = options.lineHeightMultiplier || 1.2;
        var family = options.family || "Arial, sans-serif";
        var weight = options.weight || "400";
        var maxLines = Math.max(1, options.maxLines || 1);
        var size;
        var font;
        var lineHeight;
        var maxVisibleLines;
        var wrapped;
        var fallback = null;

        for (size = maxSize; size >= minSize; size -= step) {
            font = buildFont(weight, size, family);
            lineHeight = Math.round(size * lineHeightMultiplier);
            maxVisibleLines = Math.max(1, Math.min(maxLines, Math.floor(maxHeight / lineHeight) || 1));
            ctx.font = font;
            wrapped = wrapTextDetailed(ctx, text, maxWidth, maxVisibleLines);

            fallback = {
                font: font,
                size: size,
                lineHeight: lineHeight,
                lines: wrapped.lines,
                truncated: wrapped.truncated
            };

            if (!wrapped.truncated) {
                return fallback;
            }
        }

        return fallback || {
            font: buildFont(weight, minSize, family),
            size: minSize,
            lineHeight: Math.round(minSize * lineHeightMultiplier),
            lines: [],
            truncated: false
        };
    }

    function ReviewShareBadge() {
        this.modal = document.getElementById("r9-review-share-modal");
        this.canvas = document.getElementById("r9-review-share-canvas");
        this.previewShell = this.modal ? this.modal.querySelector(".r9-review-share-preview-shell") : null;
        this.description = document.getElementById("r9-review-share-description");
        this.downloadButton = this.modal ? this.modal.querySelector(".r9-review-share-download") : null;
        this.closeButton = this.modal ? this.modal.querySelector(".r9-review-share-close") : null;
        this.closeButtons = this.modal ? this.modal.querySelectorAll("[data-review-share-close]") : [];
        this.formatList = document.getElementById("r9-review-share-format-list");
        this.presetList = document.getElementById("r9-review-share-preset-list");
        this.activeFormatIndex = 0;
        this.activePresetIndex = 0;
        this.activeReview = null;
        this.lastTrigger = null;
        this.formatButtons = [];
        this.presetButtons = [];
        this.logoImage = null;
        this.logoPromise = null;
    }

    ReviewShareBadge.prototype.init = function () {
        if (!this.modal || !this.canvas || !this.downloadButton || !this.presetList || !this.formatList) {
            return;
        }

        this.loadLogo();
        this.renderFormatButtons();
        this.renderPresetButtons();
        this.setCanvasFormat();
        this.bindEvents();
    };

    ReviewShareBadge.prototype.loadLogo = function () {
        var self = this;

        if (!config.logoUrl) {
            return Promise.resolve(null);
        }

        if (this.logoImage) {
            return Promise.resolve(this.logoImage);
        }

        if (this.logoPromise) {
            return this.logoPromise;
        }

        this.logoPromise = loadImage(config.logoUrl)
            .then(function (image) {
                self.logoImage = image;
                return image;
            })
            .catch(function () {
                self.logoPromise = null;
                return null;
            });

        return this.logoPromise;
    };

    ReviewShareBadge.prototype.bindEvents = function () {
        var self = this;

        document.addEventListener("click", function (event) {
            var trigger = event.target.closest(".r9-review-share-trigger");

            if (trigger) {
                event.preventDefault();
                self.open(trigger);
                return;
            }

            if (!self.modal.hidden && event.target.closest("[data-review-share-close]")) {
                event.preventDefault();
                self.close();
            }
        });

        document.addEventListener("keydown", function (event) {
            if (!self.modal.hidden && event.key === "Escape") {
                self.close();
            }
        });

        this.downloadButton.addEventListener("click", function () {
            self.downloadBadge();
        });
    };

    ReviewShareBadge.prototype.renderFormatButtons = function () {
        var self = this;

        FORMATS.forEach(function (format, index) {
            var button = document.createElement("button");

            button.type = "button";
            button.className = "r9-review-share-format";
            button.textContent = format.name;
            button.setAttribute("aria-label", format.name);
            button.setAttribute("title", format.name);

            button.addEventListener("click", function () {
                self.activeFormatIndex = index;
                self.updateFormatButtons();
                self.setCanvasFormat();
                self.renderBadge();
            });

            self.formatList.appendChild(button);
            self.formatButtons.push(button);
        });

        this.updateFormatButtons();
    };

    ReviewShareBadge.prototype.updateFormatButtons = function () {
        var self = this;

        this.formatButtons.forEach(function (button, index) {
            var isActive = index === self.activeFormatIndex;

            button.classList.toggle("is-active", isActive);
            button.setAttribute("aria-pressed", isActive ? "true" : "false");
        });
    };

    ReviewShareBadge.prototype.getActiveFormat = function () {
        return FORMATS[this.activeFormatIndex] || FORMATS[0];
    };

    ReviewShareBadge.prototype.setCanvasFormat = function () {
        var format = this.getActiveFormat();

        this.canvas.width = format.width;
        this.canvas.height = format.height;
        this.canvas.style.aspectRatio = format.width + " / " + format.height;
        this.canvas.setAttribute("data-format", format.id);

        if (this.previewShell) {
            this.previewShell.style.setProperty("--r9-preview-aspect-ratio", format.width + " / " + format.height);
        }

        if (this.description) {
            this.description.textContent = labels.dialogDescription;
        }
    };

    ReviewShareBadge.prototype.renderPresetButtons = function () {
        var self = this;

        PRESETS.forEach(function (preset, index) {
            var button = document.createElement("button");

            button.type = "button";
            button.className = "r9-review-share-preset";
            button.setAttribute("aria-label", preset.name);
            button.setAttribute("title", preset.name);
            button.style.setProperty("--preset-color", preset.accent);
            button.style.setProperty("--preset-gradient", "linear-gradient(135deg, " + preset.accent + " 0%, " + preset.accentDark + " 100%)");
            button.style.backgroundColor = preset.accent;
            button.style.backgroundImage = "linear-gradient(135deg, " + preset.accent + " 0%, " + preset.accentDark + " 100%)";

            button.addEventListener("click", function () {
                self.activePresetIndex = index;
                self.updatePresetButtons();
                self.renderBadge();
            });

            self.presetList.appendChild(button);
            self.presetButtons.push(button);
        });

        this.updatePresetButtons();
    };

    ReviewShareBadge.prototype.updatePresetButtons = function () {
        var self = this;

        this.presetButtons.forEach(function (button, index) {
            button.classList.toggle("is-active", index === self.activePresetIndex);
        });
    };

    ReviewShareBadge.prototype.getReviewData = function (trigger) {
        var business = normalizeWhitespace(trigger.dataset.reviewBusiness) || document.title || "Review";
        var author = normalizeWhitespace(trigger.dataset.reviewAuthor) || "Anonymous";
        var initial = normalizeWhitespace(trigger.dataset.reviewAuthorInitial) || author.charAt(0) || "?";
        var location = normalizeWhitespace(trigger.dataset.reviewLocation) || labels.fallbackLocation;
        var reviewText = normalizeWhitespace(trigger.dataset.reviewText);
        var ratingValue = Number.parseFloat(trigger.dataset.reviewRating || "0");

        if (!Number.isFinite(ratingValue)) {
            ratingValue = 0;
        }

        return {
            id: normalizeWhitespace(trigger.dataset.reviewId) || String(Date.now()),
            business: business,
            location: location,
            author: author,
            initial: initial.charAt(0).toUpperCase(),
            date: normalizeWhitespace(trigger.dataset.reviewDate),
            review: reviewText || "A customer shared a positive experience on this listing.",
            rating: Math.max(0, Math.min(5, ratingValue)),
            verified: trigger.dataset.reviewVerified === "1"
        };
    };

    ReviewShareBadge.prototype.open = function (trigger) {
        var self = this;

        this.lastTrigger = trigger;
        this.activeReview = this.getReviewData(trigger);
        this.modal.hidden = false;
        this.modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("r9-share-open");
        this.renderBadge();
        this.loadLogo().then(function () {
            self.renderBadge();
        });

        if (this.closeButton) {
            this.closeButton.focus();
        }
    };

    ReviewShareBadge.prototype.close = function () {
        this.modal.hidden = true;
        this.modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("r9-share-open");

        if (this.lastTrigger && typeof this.lastTrigger.focus === "function") {
            this.lastTrigger.focus();
        }
    };

    ReviewShareBadge.prototype.drawBackground = function (ctx, preset, width, height) {
        var gradient = ctx.createLinearGradient(0, 0, 0, height);

        gradient.addColorStop(0, preset.backgroundStart);
        gradient.addColorStop(1, preset.backgroundEnd);

        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, width, height);

        ctx.fillStyle = preset.orbOne;
        ctx.beginPath();
        ctx.arc(width - 180, 180, 230, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = preset.orbTwo;
        ctx.beginPath();
        ctx.arc(140, height - 160, 190, 0, Math.PI * 2);
        ctx.fill();

        ctx.strokeStyle = "rgba(255, 255, 255, 0.14)";
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(76, 170);
        ctx.lineTo(width - 76, 170);
        ctx.moveTo(76, height - 170);
        ctx.lineTo(width - 76, height - 170);
        ctx.stroke();
    };

    ReviewShareBadge.prototype.drawStars = function (ctx, preset, rating, x, y, scale) {
        var normalized = Math.max(0, Math.min(5, Math.round(rating * 2) / 2));
        var fullStars = Math.floor(normalized);
        var halfStar = normalized - fullStars >= 0.5;
        var index;
        var displayScale = Math.max(0.72, scale || 1);
        var boxSize = Math.max(20, Math.round(28 * displayScale));
        var boxGap = Math.max(6, Math.round(8 * displayScale));
        var boxRadius = Math.max(5, Math.round(7 * displayScale));
        var rowTop = y - Math.max(14, Math.round(22 * displayScale));
        var activeColor = "#16a34a";
        var trackColor = "rgba(22, 163, 74, 0.16)";
        var textX = x + (5 * (boxSize + boxGap)) + Math.max(8, Math.round(10 * displayScale));

        for (index = 0; index < 5; index += 1) {
            var boxX = x + (index * (boxSize + boxGap));
            var isFull = index < fullStars;
            var isHalf = !isFull && halfStar && index === fullStars;

            fillRoundedRect(ctx, boxX, rowTop, boxSize, boxSize, boxRadius, trackColor);

            if (isFull) {
                fillRoundedRect(ctx, boxX, rowTop, boxSize, boxSize, boxRadius, activeColor);
            } else if (isHalf) {
                ctx.save();
                ctx.beginPath();
                ctx.rect(boxX, rowTop, boxSize / 2, boxSize);
                ctx.clip();
                fillRoundedRect(ctx, boxX, rowTop, boxSize, boxSize, boxRadius, activeColor);
                ctx.restore();
            }

            ctx.save();
            ctx.fillStyle = isFull || isHalf ? "#ffffff" : activeColor;
            ctx.font = "700 " + Math.max(14, Math.round(18 * displayScale)) + "px Arial, sans-serif";
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillText(FILLED_STAR, boxX + (boxSize / 2), rowTop + (boxSize / 2) + 1);
            ctx.restore();
        }

        ctx.font = "600 " + Math.max(15, Math.round(21 * displayScale)) + "px Arial, sans-serif";
        ctx.fillStyle = preset.muted;
        ctx.fillText(rating.toFixed(1) + " / 5", textX, y);
    };

    ReviewShareBadge.prototype.drawBrandBadge = function (ctx, preset, brandName, x, y, width, height) {
        var hasLogo = !!(this.logoImage && this.logoImage.naturalWidth && this.logoImage.naturalHeight);
        var brandFill = "rgba(255, 255, 255, 0.78)";
        var imageSize;
        var imageX;
        var imageY;

        fillRoundedRect(ctx, x, y, width, height, 22, brandFill);

        if (hasLogo) {
            imageSize = getContainedImageSize(this.logoImage.naturalWidth, this.logoImage.naturalHeight, width - 16, height - 8);
            imageX = x + ((width - imageSize.width) / 2);
            imageY = y + ((height - imageSize.height) / 2);
            ctx.drawImage(this.logoImage, imageX, imageY, imageSize.width, imageSize.height);
        } else {
            ctx.font = "700 20px Arial, sans-serif";
            ctx.fillStyle = preset.chipText;
            ctx.textAlign = "center";
            ctx.fillText(fitTextSingleLine(ctx, brandName.toUpperCase(), width - 20), x + (width / 2), y + 36);
            ctx.textAlign = "left";
        }
    };

    ReviewShareBadge.prototype.drawBadge = function (ctx, review, preset, format) {
        var width = this.canvas.width;
        var height = this.canvas.height;
        var cardMarginX = Math.max(60, Math.round(width * 0.0925));
        var cardMarginY = Math.max(46, Math.round(height * 0.068));
        var card = {
            x: cardMarginX,
            y: cardMarginY,
            width: width - (cardMarginX * 2),
            height: height - (cardMarginY * 2),
            radius: Math.max(28, Math.round(Math.min(width, height) * 0.048))
        };
        var baseScale = Math.min(card.width / 880, card.height / 1166);
        var contentScale = Math.max(0.72, baseScale);
        var brandName = normalizeWhitespace(config.siteName || "Review9ja");
        var quoteText = normalizeWhitespace(review.review);
        var contentInsetX = Math.max(32, Math.round(card.width * 0.066));
        var contentX = card.x + contentInsetX;
        var contentWidth = card.width - (contentInsetX * 2);
        var cursorY;
        var footerY;
        var availableQuoteHeight;
        var businessLayout;
        var businessBottom;
        var quoteLayout;
        var avatarRadius;
        var avatarX;
        var authorX;
        var brandBadgeWidth;
        var brandBadgeHeight;
        var quoteY;
        var quoteTextY;
        var quoteBlockHeight;
        var badgeX;
        var badgeY;
        var authorMaxWidth;

        this.drawBackground(ctx, preset, width, height);

        ctx.save();
        ctx.shadowColor = "rgba(15, 23, 42, 0.14)";
        ctx.shadowBlur = Math.max(24, Math.round(40 * contentScale));
        ctx.shadowOffsetY = Math.max(10, Math.round(18 * contentScale));
        fillRoundedRect(ctx, card.x, card.y, card.width, card.height, card.radius, preset.card);
        ctx.restore();

        strokeRoundedRect(ctx, card.x, card.y, card.width, card.height, card.radius, preset.cardBorder, Math.max(2, Math.round(3 * contentScale)));

        cursorY = card.y + Math.max(44, Math.round(card.height * 0.067));

        if (review.date) {
            ctx.font = "600 " + Math.max(12, Math.round(18 * contentScale)) + "px Arial, sans-serif";
            ctx.fillStyle = preset.muted;
            ctx.textAlign = "right";
            ctx.fillText(
                fitTextSingleLine(ctx, review.date, Math.max(180, Math.round(card.width * 0.26))),
                card.x + card.width - contentInsetX,
                cursorY
            );
            ctx.textAlign = "left";
        }

        cursorY += Math.max(24, Math.round(34 * contentScale));

        businessLayout = resolveTextLayout(ctx, review.business, contentWidth, Math.max(68, Math.round(126 * contentScale)), {
            maxSize: Math.max(24, Math.round(46 * contentScale)),
            minSize: Math.max(18, Math.round(30 * contentScale)),
            maxLines: 2,
            weight: "700",
            family: "Arial, sans-serif",
            lineHeightMultiplier: 1.04
        });
        ctx.font = businessLayout.font;
        businessBottom = drawTextLines(ctx, businessLayout.lines, contentX, cursorY, businessLayout.lineHeight, preset.text);
        cursorY = businessBottom + businessLayout.lineHeight + Math.max(8, Math.round(12 * contentScale));

        this.drawStars(ctx, preset, review.rating || 0, contentX, cursorY, contentScale);
        cursorY += Math.max(40, Math.round(56 * contentScale));

        footerY = card.y + card.height - Math.max(88, Math.round(118 * contentScale));
        quoteY = cursorY + Math.max(12, Math.round(18 * contentScale));
        availableQuoteHeight = Math.max(100, footerY - quoteY - Math.max(28, Math.round(48 * contentScale)));
        quoteLayout = resolveTextLayout(ctx, quoteText, contentWidth - 4, availableQuoteHeight, {
            maxSize: Math.max(20, Math.round(38 * contentScale)),
            minSize: Math.max(16, Math.round(24 * contentScale)),
            maxLines: format && format.id === "landscape" ? 7 : 9,
            weight: "600",
            family: "Arial, sans-serif",
            lineHeightMultiplier: 1.14
        });

        quoteBlockHeight =
            (Math.max(quoteLayout.lines.length - 1, 0) * quoteLayout.lineHeight) +
            quoteLayout.size;
        quoteTextY =
            quoteY +
            Math.max(0, Math.floor((availableQuoteHeight - quoteBlockHeight) / 2)) +
            quoteLayout.size;

        ctx.font = "700 " + Math.max(56, Math.round(96 * contentScale)) + "px Georgia, serif";
        ctx.fillStyle = preset.quoteTint;
        ctx.fillText('"', contentX - Math.max(4, Math.round(6 * contentScale)), quoteTextY - Math.max(12, Math.round(18 * contentScale)));

        ctx.font = quoteLayout.font;
        drawTextLines(ctx, quoteLayout.lines, contentX, quoteTextY, quoteLayout.lineHeight, preset.text);

        ctx.beginPath();
        ctx.fillStyle = preset.avatarFill;
        avatarRadius = Math.max(24, Math.round(36 * contentScale));
        avatarX = contentX + avatarRadius;
        ctx.arc(avatarX, footerY, avatarRadius, 0, Math.PI * 2);
        ctx.fill();

        ctx.font = "700 " + Math.max(22, Math.round(34 * contentScale)) + "px Arial, sans-serif";
        ctx.fillStyle = preset.avatarText;
        ctx.textAlign = "center";
        ctx.fillText(review.initial || "?", avatarX, footerY + Math.max(8, Math.round(12 * contentScale)));
        ctx.textAlign = "left";

        brandBadgeWidth = Math.max(156, Math.round(220 * contentScale));
        brandBadgeHeight = Math.max(54, Math.round(76 * contentScale));
        badgeX = card.x + card.width - brandBadgeWidth - contentInsetX;
        badgeY = footerY - Math.round(brandBadgeHeight * 0.55);
        authorX = avatarX + avatarRadius + Math.max(12, Math.round(18 * contentScale));
        authorMaxWidth = Math.max(140, badgeX - authorX - Math.max(16, Math.round(24 * contentScale)));

        ctx.font = "700 " + Math.max(20, Math.round(30 * contentScale)) + "px Arial, sans-serif";
        ctx.fillStyle = preset.text;
        ctx.fillText(fitTextSingleLine(ctx, review.author, authorMaxWidth), authorX, footerY - Math.max(2, Math.round(4 * contentScale)));

        ctx.font = "600 " + Math.max(15, Math.round(22 * contentScale)) + "px Arial, sans-serif";
        ctx.fillStyle = preset.muted;
        ctx.fillText(review.verified ? labels.verified : "Reviewer", authorX, footerY + Math.max(18, Math.round(28 * contentScale)));

        this.drawBrandBadge(
            ctx,
            preset,
            brandName,
            badgeX,
            badgeY,
            brandBadgeWidth,
            brandBadgeHeight
        );
    };

    ReviewShareBadge.prototype.renderBadge = function () {
        var ctx;
        var preset;
        var format;

        if (!this.activeReview) {
            return;
        }

        ctx = this.canvas.getContext("2d");
        if (!ctx) {
            return;
        }

        preset = PRESETS[this.activePresetIndex] || PRESETS[0];
        format = this.getActiveFormat();
        ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.drawBadge(ctx, this.activeReview, preset, format);
    };

    ReviewShareBadge.prototype.downloadBadge = function () {
        var self = this;
        var filenameBase;
        var format = this.getActiveFormat();

        if (!this.activeReview) {
            return;
        }

        filenameBase =
            (slugify(config.downloadFilenamePrefix || "review9ja") || "review9ja") +
            "-review-" +
            (slugify(this.activeReview.business) || this.activeReview.id || "badge") +
            "-" +
            (format.id || "portrait");

        if (this.canvas.toBlob) {
            this.canvas.toBlob(function (blob) {
                var link;
                var objectUrl;

                if (!blob) {
                    return;
                }

                objectUrl = window.URL.createObjectURL(blob);
                link = document.createElement("a");
                link.href = objectUrl;
                link.download = filenameBase + ".png";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.setTimeout(function () {
                    window.URL.revokeObjectURL(objectUrl);
                }, 1500);
            }, "image/png");

            return;
        }

        (function () {
            var dataUrl = self.canvas.toDataURL("image/png");
            var link = document.createElement("a");

            link.href = dataUrl;
            link.download = filenameBase + ".png";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }());
    };

    document.addEventListener("DOMContentLoaded", function () {
        var reviewShareBadge = new ReviewShareBadge();

        reviewShareBadge.init();
    });
}());
