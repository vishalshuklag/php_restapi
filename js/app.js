const postsDiv = document.getElementById("posts");
const categoryDiv = document.getElementById("category");

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
                                <footer class="blockquote-footer">By <cite title="Author Name">${post.author}</cite></footer>
                              </div>
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
}

document.addEventListener("DOMContentLoaded", renderPosts);
document.addEventListener("DOMContentLoaded", renderCategories);
