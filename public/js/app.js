// ── BANNER SLIDER ──
const slides = document.getElementById("slides");
const dots = document.querySelectorAll(".dot");
const progress = document.getElementById("progress");
let current = 0;
let timer;

function goTo(idx) {
  current = (idx + 3) % 3;
  slides.style.transform = `translateX(-${(current * 100) / 3}%)`;
  dots.forEach((d, i) => d.classList.toggle("active", i === current));
  // restart progress animation
  progress.style.animation = "none";
  progress.offsetHeight; // reflow
  progress.style.animation = "progressBar 4s linear infinite";
}

function startAuto() {
  clearInterval(timer);
  timer = setInterval(() => goTo(current + 1), 4000);
}

document.getElementById("next").addEventListener("click", () => {
  goTo(current + 1);
  startAuto();
});
document.getElementById("prev").addEventListener("click", () => {
  goTo(current - 1);
  startAuto();
});
dots.forEach((d) =>
  d.addEventListener("click", () => {
    goTo(+d.dataset.index);
    startAuto();
  }),
);

startAuto();

// ── COUNTDOWN TIMER ──
let total = 5 * 3600 + 42 * 60 + 30;
function updateCountdown() {
  const h = Math.floor(total / 3600);
  const m = Math.floor((total % 3600) / 60);
  const s = total % 60;
  document.getElementById("cd-h").childNodes[0].nodeValue = String(h).padStart(
    2,
    "0",
  );
  document.getElementById("cd-m").childNodes[0].nodeValue = String(m).padStart(
    2,
    "0",
  );
  document.getElementById("cd-s").childNodes[0].nodeValue = String(s).padStart(
    2,
    "0",
  );
  if (total > 0) total--;
}
updateCountdown();
setInterval(updateCountdown, 1000);

// ── FILTER CHIPS ──
document.querySelectorAll(".cat-chip").forEach((chip) => {
  chip.addEventListener("click", function (e) {
    e.preventDefault();
    document
      .querySelectorAll(".cat-chip")
      .forEach((c) => c.classList.remove("active"));
    this.classList.add("active");
  });
});

// ── FOOTER ──

const btn = document.getElementById("backToTop");
window.addEventListener("scroll", () => {
  btn.classList.toggle("visible", window.scrollY > 400);
});
btn.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});
