const items = document.querySelectorAll('.item');
const events = ['click', 'touchend'];

const btnone = document.querySelector('.btnone');
const btntwo = document.querySelector('.btntwo');
const btnthree = document.querySelector('.btnthree');
const sigin = document.querySelectorAll('.signin');
const register = document.querySelector('.register');

const student = document.querySelector('.student');
const tutor = document.querySelector('.tutor');
const content = document.querySelector('.content');

sigin.forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.preventDefault();
    items[4].classList.add('active');
    items[4].classList.remove('deactive');
    items[0].classList.add('deactive');
  });
});

register.addEventListener('click', (e) => {
  e.preventDefault();
  items[0].classList.add('active');
  items[0].classList.remove('deactive');
  items[4].classList.remove('active');
});

btnone.addEventListener('click', (e) => {
  e.preventDefault();
  if (student.checked) {
    items[1].classList.add('active');
    items[1].classList.remove('deactive');
    items[0].classList.add('deactive');
  } else if (tutor.checked) {
    items[2].classList.add('active');
    items[2].classList.remove('deactive');
    items[0].classList.add('deactive');
  } else if (content.checked) {
    items[3].classList.add('active');
    items[3].classList.remove('deactive');
    items[0].classList.add('deactive');
  }
});
