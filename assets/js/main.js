(() => {
  const setActiveMenuItem = () => {
    const links = document.querySelectorAll(
      ".menu-item-has-children > .nav-link"
    );
    links.forEach((link) => {
      // Inicializa atributos ARIA
      link.setAttribute("aria-expanded", "false");
      const submenu = link.nextElementSibling;
      if (submenu && submenu.classList.contains("sub-menu"))
        submenu.setAttribute("aria-hidden", "true");

      link.addEventListener("click", (e) => {
        // Solo prevenir el default si el href es #0
        if (link.getAttribute("href") === "#0") e.preventDefault();

        // link ---------> A.nav-link
        const parentItem = link.closest(".menu-item"); // LI
        const currentSubMenu = link.nextElementSibling; // UL.sub-menu

        // Si ya está abierto, lo cerramos
        const isOpen = currentSubMenu.classList.contains("open"); // FALSE

        // Cerrar otros submenús del mismo nivel
        const siblingItems = Array.from(parentItem.parentElement.children);
        siblingItems.forEach((item) => {
          // Si el "item" es disinto al padre que acabamos de clickear y el "item" tiene submenú
          if (
            item !== parentItem &&
            item.classList.contains("menu-item-has-children")
          ) {
            // Cerrar el submenú
            const sub = item.querySelector(".sub-menu");
            const toggleLink = item.querySelector(".nav-link");
            if (sub && sub.classList.contains("open")) {
              sub.classList.remove("open");
              toggleLink.setAttribute("aria-expanded", "false");
              sub.setAttribute("aria-hidden", "true");
            }
          }
        });

        // Alternar estado del actual
        if (!isOpen) {
          currentSubMenu.classList.add("open");
          link.setAttribute("aria-expanded", "true");
          currentSubMenu.setAttribute("aria-hidden", "false");
        } else {
          currentSubMenu.classList.remove("open");
          link.setAttribute("aria-expanded", "false");
          currentSubMenu.setAttribute("aria-hidden", "true");
        }
      });
    });
  };

  const toggleStickyHeader = () => {
    const header = document.querySelector("#header");

    if (window.scrollY > 36) {
      header.classList.add("sticky-top", "shadow", "bg-white-1");
      header.classList.remove("position-relative");
    } else {
      header.classList.remove("sticky-top", "shadow", "bg-white-1");
      header.classList.add("position-relative");
    }
  };

  const initializeMobileMenuToggles = () => {
    const toggles = document.querySelectorAll("#menu-mobile .menu__toggle");

    toggles.forEach((toggle) => {
      toggle.addEventListener("click", () => {
        const parentItem = toggle.closest(".menu__item");
        const submenu = parentItem.querySelector(".menu__list--submenu");
        const isOpen = toggle.getAttribute("aria-expanded") === "true";
        toggle.setAttribute("aria-expanded", String(!isOpen));
        if (submenu) submenu.style.display = isOpen ? "none" : "block";
      });
    });

    // Extra: Detecta <a href="#0"> con submenús y actúa como si fuera un toggle
    const fakeLinks = document.querySelectorAll('.menu__link[href="#0"]');

    fakeLinks.forEach((link) => {
      const parentItem = link.closest(".menu__item");
      const toggle = parentItem.querySelector(".menu__toggle");
      const submenu = parentItem.querySelector(".menu__list--submenu");

      if (toggle && submenu) {
        link.addEventListener("click", (e) => {
          e.preventDefault(); // Evita el scroll al top
          const isOpen = toggle.getAttribute("aria-expanded") === "true";
          toggle.setAttribute("aria-expanded", String(!isOpen));
          submenu.style.display = isOpen ? "none" : "block";
        });
      }
    });
  };

  const initializeYouTubeLazyLoad = () => {
    document.querySelectorAll(".youtube-lazy").forEach(function (el) {
      el.addEventListener("click", function () {
        const id = this.getAttribute("data-id");
        const iframe = document.createElement("iframe");
        iframe.setAttribute(
          "src",
          "https://www.youtube.com/embed/" + id + "?autoplay=1"
        );
        iframe.setAttribute("frameborder", "0");
        iframe.setAttribute("allowfullscreen", "1");
        iframe.setAttribute(
          "allow",
          "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        );
        iframe.classList.add("w-100", "h-100");
        this.innerHTML = "";
        this.appendChild(iframe);
      });
    });
  };

  const initDOMReady = () => {
    // MENU PC
    toggleStickyHeader();
    setActiveMenuItem();
    // MENU MOBILE
    initializeMobileMenuToggles();
    // YOUTUBE
    initializeYouTubeLazyLoad();
  };

  document.addEventListener("DOMContentLoaded", initDOMReady);
  window.addEventListener("scroll", toggleStickyHeader);
})();
