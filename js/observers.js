const elsIn = document.querySelectorAll('.fade-in');
const elsLeft = document.querySelectorAll('.fade-left');
const elsRight = document.querySelectorAll('.fade-right');

const appearOptions = {
  threshold: 0,
  rootMargin: '0px 0px -250px 0px',
};

const appearOnScroll = new IntersectionObserver(function (
  entries,
  appearOnScroll,
) {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) {
      return;
    } else {
      entry.target.classList.add('appear');
      appearOnScroll.unobserve(entry.target);
    }
  });
},
appearOptions);

elsIn.forEach((el) => {
  appearOnScroll.observe(el);
});

elsLeft.forEach((el) => {
  appearOnScroll.observe(el);
});

elsRight.forEach((el) => {
  appearOnScroll.observe(el);
});
