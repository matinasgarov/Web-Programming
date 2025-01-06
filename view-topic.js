const postsDiv = document.querySelector("#posts");

function renderPost(post) {
  return `
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">${post.username}</h5>
        <h6 class="card-subtitle mb-2 text-muted">${post.date}</h6>
        <p class="card-text">${post.text}</p>
      </div>
    </div>
  `;
}

function renderPosts(posts) 
{
  const postsAsArray = Object.keys(posts)
    .map((key) => posts[key])
    .reverse();
  
  return postsAsArray.map(renderPost).join("\n");
}

async function getPosts() {
 
  const urlSearchParams = new URLSearchParams(location.search);
  const teamId = urlSearchParams.get("teamId");

  const response = await fetch(`api/get-posts.php?teamId=${teamId}`);
  const posts = await response.json();

 
  postsDiv.innerHTML = renderPosts(posts);
}

window.addEventListener("load", getPosts);


const textarea = document.querySelector("#post");
const button = document.querySelector("#send-post");
const errorDiv = document.querySelector("#err");

async function handleButtonClick() {
  errorDiv.innerHTML = "";

  const urlSearchParams = new URLSearchParams(location.search);
  const teamId = urlSearchParams.get("teamId");
  const postText = textarea.value;

  if (postText == "") {
    errorDiv.innerHTML = `<div class="alert alert-danger">Text area cannot be sent while it is empty</div>`;
    return;
  }

  const formData = new FormData();
  formData.append("text", postText);
  formData.append("teamId", teamId);


  const response = await fetch("api/create-post.php", {
    method: "POST",
    body: formData,
  });

  if (response.ok) {
    getPosts();
    textarea.value = "";
  } else {
    alert("Could not send your post");
  }
}
button.addEventListener("click", handleButtonClick);