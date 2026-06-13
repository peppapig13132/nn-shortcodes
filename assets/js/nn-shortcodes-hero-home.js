(function () {
  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var DEFAULT_DELAY_MS = 800;

  function parseDelayMs(root) {
    var seconds = parseFloat(root.getAttribute("data-grow-delay"));
    if (isNaN(seconds) || seconds < 0) {
      return DEFAULT_DELAY_MS;
    }
    return seconds * 1000;
  }

  function startAnimation(root) {
    if (root.classList.contains("nn-hero-home--animate")) {
      return;
    }
    root.classList.add("nn-hero-home--animate");
  }

  function scheduleAnimation(root) {
    if (prefersReducedMotion) {
      startAnimation(root);
      return;
    }

    var delayMs = parseDelayMs(root);

    function run() {
      setTimeout(function () {
        startAnimation(root);
      }, delayMs);
    }

    if (document.readyState === "complete") {
      run();
    } else {
      window.addEventListener("load", run, { once: true });
    }
  }

  document.querySelectorAll(".nn-hero-home").forEach(scheduleAnimation);
})();
