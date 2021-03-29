const postsDiv = document.getElementById("posts");
const categoryDiv = document.getElementById("category");
const showPostForm = document.querySelector("#addPost");
const postForm = document.querySelector("#postForm");

/**
 * Fetch data from server and render it on web
 * fetchPosts() -> fetch data and pass it to renderPost()
 */
async function fetchPosts() {
  try {
    const response = await fetch("./app/api/post/read.php");
    if (response.status === 200) {
      return await response.json();
    }
  } catch (error) {
    console.log("Something went wrong !!");
  }
}
async function renderPosts() {
  const posts = await fetchPosts();
  let html = "";
  posts.forEach((post) => {
    let htmlSegment = `  <div class="col-md-6">
                          <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                              <h1 class="card-title text-primary"><a href="post.html?id=${post.id}">${post.title}</a></h1>
                              <p class="badge badge-primary">${post.category_name}</p>
                              <p class="card-text">${post.body}</p>
                              <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-outline-primary">View</button>
                                <button class="btn btn-outline-warning" id="deletePost">Delete</button>
                                <footer class="blockquote-footer">By <cite title="Author Name">${post.author}</cite></footer>
                              </div>
                              <p class="mt-1">Created at : ${post.created_at}</p>
                            </div>
                          </div>
                        </div>`;

    html += htmlSegment;
  });

  let container = document.querySelector("#posts");
  container.innerHTML = html;
}

async function fetchCategories() {
  try {
    const response = await fetch("./app/api/category/read.php");
    if (response.status === 200) {
      return await response.json();
    }
  } catch (error) {
    console.log("Something Went Wrong !!");
  }
}

async function renderCategories() {
  const categories = await fetchCategories();
  const htmlElement = categories
    .map((category) => {
      return `
    <li class="list-group-item">${category.name}</li>
    `;
    })
    .join("");
  const categoryDiv = document.querySelector("#categories");
  categoryDiv.innerHTML = htmlElement;
  const categorySelect = document.querySelector("#category-id");
  categorySelect.innerHTML = categories
    .map((category) => {
      return `<option value="${category.id}">${category.name}</option>`;
    })
    .join("");
}

/**
 * Display form to make POST req and register Post
 *
 */
function displayForm() {
  const formDiv = document.querySelector("#postFormDiv");
  if (formDiv != null) {
    if (formDiv.style.display == "block") {
      formDiv.style.display = "none";
    } else {
      formDiv.style.display = "block";
    }
    return false;
  }
}

/* Helper function for POSTing data as JSON with fetch */
async function postFormData({ url, formData }) {
  const plainFormData = Object.fromEntries(formData.entries());
  const formDataJsonString = JSON.stringify(plainFormData);
  const fetchOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    body: formDataJsonString,
  };

  const response = await fetch(url, fetchOptions);
  if (!response.ok) {
    const errorMessage = await response.json();
    throw new Error(errorMessage);
  }
  return response.json();
}

/* Event handler for a form submit event.*/
async function handlePostFormSubmit(event) {
  event.preventDefault();
  const form = event.currentTarget;
  const url = "http://localhost/php_restapi/app/api/post/create.php";
  try {
    const formData = new FormData(form);
    const responseData = await postFormData({ url, formData });
    renderPosts();
  } catch (error) {
    console.error(error);
  }
  form.reset();
}

document.addEventListener("DOMContentLoaded", renderPosts);
document.addEventListener("DOMContentLoaded", renderCategories);
showPostForm.addEventListener("click", displayForm);
postForm.addEventListener("submit", handlePostFormSubmit);
