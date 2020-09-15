const page = document.querySelectorAll('.page');
const url = new URL(location.href);
const params = url.searchParams;
const currentPage = params.get('page');

if (currentPage) {
  page[currentPage - 1].children[0].classList.add('active');
} else {
  page[0].children[0].classList.add('active');
}
