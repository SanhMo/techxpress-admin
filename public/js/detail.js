// ── Gallery thumbnails ──
document.querySelectorAll(".thumb").forEach((btn) => {
    btn.addEventListener("click", function () {
        document
            .querySelectorAll(".thumb")
            .forEach((t) => t.classList.remove("active"));
        this.classList.add("active");
        const mainImg = document.getElementById("mainImg");
        mainImg.style.opacity = "0";
        mainImg.style.transform = "scale(0.97)";
        setTimeout(() => {
            mainImg.src = this.dataset.img;
            mainImg.style.opacity = "1";
            mainImg.style.transform = "scale(1)";
        }, 160);
    });
});

// ── Variant selector ──
document.querySelectorAll(".vopt, .vopt-color").forEach((btn) => {
    btn.addEventListener("click", function () {
        const group = this.dataset.group;
        document
            .querySelectorAll(`[data-group="${group}"]`)
            .forEach((b) => b.classList.remove("active"));
        this.classList.add("active");
        const chosenMap = {
            ram: "ramChosen",
            ssd: "ssdChosen",
            color: "colorChosen",
        };
        if (chosenMap[group]) {
            document.getElementById(chosenMap[group]).textContent =
                this.dataset.val;
        }
    });
});

// ── Quantity ──
let qty = 1;
const qtyVal = document.getElementById("qtyVal");
document.getElementById("qtyMinus").addEventListener("click", () => {
    if (qty > 1) {
        qty--;
        qtyVal.textContent = qty;
    }
});
document.getElementById("qtyPlus").addEventListener("click", () => {
    if (qty < 28) {
        qty++;
        qtyVal.textContent = qty;
    }
});

// ── Wishlist toggle ──
const wishBtn = document.getElementById("wishBtn");
wishBtn.addEventListener("click", function () {
    const icon = this.querySelector("i");
    icon.classList.toggle("fa-regular");
    icon.classList.toggle("fa-solid");
    this.classList.toggle("wished");
});

// ── Tabs ──
document.querySelectorAll(".tab-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
        document
            .querySelectorAll(".tab-btn")
            .forEach((b) => b.classList.remove("active"));
        document
            .querySelectorAll(".tab-panel")
            .forEach((p) => p.classList.remove("active"));
        this.classList.add("active");
        document
            .getElementById("tab-" + this.dataset.tab)
            .classList.add("active");
    });
});
