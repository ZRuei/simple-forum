const page = document.querySelectorAll('.page');
const url = new URL(location.href);
const params = url.searchParams;
const currentPage = params.get('page');

const messageCards = document.querySelector('.message-cards');
const form = document.querySelector('.container > form');
const textarea = document.querySelector('textarea[name=content]');
const message = document.querySelector('.message');

// 

const commentTemplate = `
  <div class="card">
    <div class="avatar"><img src="#" alt=""></div>
    <div class="message">
      <div class="message__info">
        <div class="message__info--author">
          By <span>$nickname</span> <span>$created_at</span>
          <span><a class="edit-btn" href="./update_comment.view.php?id=$id">編輯</a></span>
          <span><a class="del-btn" href="./delete_comment.php?id=$id">刪除</a></span>
        </div>
      </div>
      <div class="message__content">
        $content
      </div>
    </div>
  </div>
`;

if (currentPage) {
  page[currentPage - 1].children[0].classList.add('active');
} else {
  page[0].children[0].classList.add('active');
}

function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// const xhr = new XMLHttpRequest();
// xhr.open('GET', `php_api/comments.php?page=${escapeHtml(currentPage)}`, true);

// xhr.onload = function () {
//   if (this.status >= 200 && this.status < 400) {
//     const data = JSON.parse(this.response);
//     const { comments } = data;
//     comments.forEach((comment) => {
//       messageCards.insertAdjacentHTML('beforeend',
//         commentTemplate
//           .replace('$nickname', escapeHtml(comment.nickname))
//           .replace('$created_at', escapeHtml(comment.created_at))
//           .replace('$content', escapeHtml(comment.content)));
//     });
//   } else {
//     console.log('err');
//   }
// };
// xhr.onerror = function () {
//   console.log('err');
// };
// xhr.send();

form.addEventListener('submit', (e) => {
  e.preventDefault();
  const content = textarea.value;
  const xhr = new XMLHttpRequest();
  const params = `content=${encodeURIComponent(content)}`;

  xhr.open('POST', 'add_comment.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
  xhr.send(params);
  xhr.onload = function () {
    if (this.status >= 200 && this.status < 400) {
      textarea.value = '';
      const {
        ok, message, id, nickname, content, createdAt
      } = JSON.parse(this.response);
      if (!ok) {
        messageCards.insertAdjacentHTML('afterbegin', message);
        return;
      }
      messageCards.insertAdjacentHTML(
        'afterbegin',
        commentTemplate
          .replace('$nickname', escapeHtml(nickname.toString()))
          .replace('$created_at', escapeHtml(createdAt.toString()))
          .replace('$content', escapeHtml(content.toString()))
          .replace('$id', escapeHtml(id.toString()))
      );
    }
  };
});
