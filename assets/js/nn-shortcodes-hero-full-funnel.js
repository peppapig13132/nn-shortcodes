(function () {
  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  function formatCount(value, decimals, prefix, suffix) {
    var fixed = Number(value).toFixed(decimals);
    if (decimals === 0) {
      fixed = String(Math.round(Number(value)));
    }
    return (prefix || "") + fixed + (suffix || "");
  }

  function setFinalCounts(root) {
    root.querySelectorAll("[data-nn-count]").forEach(function (el) {
      var target = parseFloat(el.getAttribute("data-nn-target")) || 0;
      var decimals = parseInt(el.getAttribute("data-nn-decimals"), 10);
      if (isNaN(decimals)) {
        decimals = 0;
      }
      var prefix = el.getAttribute("data-nn-prefix") || "";
      var suffix = el.getAttribute("data-nn-suffix") || "";
      el.textContent = formatCount(target, decimals, prefix, suffix);
      el.style.opacity = "1";
    });
  }

  function showStatic(root) {
    root.querySelectorAll(".nn-hero-full-funnel__table tbody tr").forEach(function (row) {
      row.style.opacity = "1";
      row.style.transform = "none";
    });
    setFinalCounts(root);
  }

  function animateCount(el, duration, delay) {
    var target = parseFloat(el.getAttribute("data-nn-target")) || 0;
    var decimals = parseInt(el.getAttribute("data-nn-decimals"), 10);
    if (isNaN(decimals)) {
      decimals = 0;
    }
    var prefix = el.getAttribute("data-nn-prefix") || "";
    var suffix = el.getAttribute("data-nn-suffix") || "";

    if (prefersReducedMotion || typeof gsap === "undefined") {
      el.textContent = formatCount(target, decimals, prefix, suffix);
      el.style.opacity = "1";
      return;
    }

    var counter = { value: 0 };
    gsap.to(counter, {
      value: target,
      duration: duration,
      delay: delay,
      ease: "power2.out",
      onUpdate: function () {
        el.textContent = formatCount(counter.value, decimals, prefix, suffix);
      },
      onComplete: function () {
        el.textContent = formatCount(target, decimals, prefix, suffix);
      },
    });
  }

  function initBlock(root, animated) {
    if (root.getAttribute("data-nn-initialized") === "1") {
      return;
    }
    root.setAttribute("data-nn-initialized", "1");

    var duration = parseFloat(root.getAttribute("data-duration")) || 2;
    var rows = root.querySelectorAll(".nn-hero-full-funnel__table tbody tr");
    var counts = root.querySelectorAll("[data-nn-count]");

    if (!animated || prefersReducedMotion || typeof gsap === "undefined") {
      showStatic(root);
      return;
    }

    gsap.set(rows, { opacity: 0, y: 10 });
    gsap.set(counts, { opacity: 0 });

    var tl = gsap.timeline({ defaults: { ease: "power2.out" } });

    if (rows.length) {
      tl.to(
        rows,
        {
          opacity: 1,
          y: 0,
          duration: 0.45,
          stagger: 0.1,
        },
        0
      );
    }

    tl.to(
      counts,
      {
        opacity: 1,
        duration: 0.2,
        stagger: 0.06,
      },
      0.2
    );

    counts.forEach(function (el, index) {
      animateCount(el, duration * 0.85, 0.25 + index * 0.08);
    });
  }

  function observeBlock(root) {
    var fallbackTimer = window.setTimeout(function () {
      initBlock(root, false);
    }, 1200);

    function run(animated) {
      window.clearTimeout(fallbackTimer);
      initBlock(root, animated);
    }

    if (!("IntersectionObserver" in window)) {
      run(true);
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          run(true);
          observer.unobserve(entry.target);
        });
      },
      { threshold: 0.05, rootMargin: "40px 0px 40px 0px" }
    );

    observer.observe(root);
  }

  function boot() {
    document.querySelectorAll(".nn-hero-full-funnel").forEach(observeBlock);
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", boot);
  } else {
    boot();
  }
})();
