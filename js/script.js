// Modal logic
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
    
    // Clear previous messages and inputs
    const modal = document.getElementById(modalId);
    const messages = modal.querySelectorAll('.form-message');
    messages.forEach(msg => msg.style.display = 'none');
    
    // reset form if inside this modal
    const form = modal.querySelector('form');
    if (form) form.reset();
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal if clicked outside of the inner content
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Show form message
function showMessage(modalId, type, messageText) {
    const msgElement = document.getElementById(modalId === 'loginModal' ? 'loginMessage' : 'registerMessage');
    if (msgElement) {
        msgElement.className = 'form-message ' + type;
        msgElement.textContent = messageText;
        msgElement.style.display = 'block';
    }
}

// Login Form Submit
document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;

            try {
                const res = await fetch('api/posts/users/login.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                
                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseErr) {
                    console.error('Server returned non-JSON response:', text);
                    throw new Error('Invalid server response. Check Console (F12).');
                }
                
                if (data.status === 'success') {
                    showMessage('loginModal', 'success', data.message);
                    setTimeout(() => {
                        closeModal('loginModal');
                        // In a real app we might redirect to dashboard or change Auth Buttons to "Logout"
                        alert('Welcome ' + data.data.name + '!');
                    }, 1000);
                } else {
                    showMessage('loginModal', 'error', data.message || 'Login failed.');
                }
            } catch (err) {
                console.error(err);
                showMessage('loginModal', 'error', 'An error occurred. Please try again.');
            }
        });
    }

    // Register Form Submit
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;

            try {
                const res = await fetch('api/posts/users/register.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password })
                });
                
                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (parseErr) {
                    console.error('Server returned non-JSON response:', text);
                    throw new Error('Invalid server response. Check Console (F12).');
                }

                if (data.status === 'success') {
                    showMessage('registerModal', 'success', data.message);
                    setTimeout(() => {
                        closeModal('registerModal');
                        openModal('loginModal'); // Prompt to log in
                    }, 1500);
                } else {
                    showMessage('registerModal', 'error', data.message || 'Registration failed.');
                }
            } catch (err) {
                console.error(err);
                showMessage('registerModal', 'error', 'An error occurred. Please try again.');
            }
        });
    }

    // Navigation Toggle
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
hamburger.addEventListener('click', () =>{
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Close NavLinks When Click a Link
document.querySelectorAll('.nav-links li a').forEach(link =>{
    link.addEventListener('click', () =>{
        if(hamburger.classList.contains('active')){
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }
    });
    // blog Section Logic
    fetchPosts();
});

async function fetchPosts() {
    const blogGrid = document.getElementById('blog-grid');
    if (!blogGrid) return;

    try {
        const res = await fetch('api/posts/read.php');
        const data = await res.json();

        if (data.status === 'success' && data.data.length > 0) {
            renderPosts(data.data);
        } else {
            blogGrid.innerHTML = '<div class="info-message">No farming insights found at the moment. Stay tuned!</div>';
        }
    } catch (err) {
        console.error('Error fetching posts:', err);
        blogGrid.innerHTML = '<div class="error-message">Oops! Could not load the latest news. Please try again later.</div>';
    }
}

function renderPosts(posts) {
    const blogGrid = document.getElementById('blog-grid');
    blogGrid.innerHTML = ''; // Clear loading state

    posts.forEach(post => {
        const date = new Date(post.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const card = `
            <article class="blog-card">
                <div class="blog-image">
                    <i>🌿</i>
                </div>
                <div class="blog-content">
                    <h3>${post.title}</h3>
                    <p>${post.preview}...</p>
                    <div class="blog-meta">
                        <span class="author">By ${post.author}</span>
                        <span class="date">${date}</span>
                    </div>
                </div>
            </article>
        `;
        blogGrid.innerHTML += card;
    });
}
});



