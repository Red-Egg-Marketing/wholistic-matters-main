const header = document.querySelector('header');
const main = document.querySelector('main');

if (header && main) {
  const updateMargin = () => {
    main.style.marginTop = `${header.offsetHeight}px`;
  };

  new ResizeObserver(updateMargin).observe(header);
  updateMargin();
}