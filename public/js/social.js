const likeButtons = document.querySelectorAll('.like-btn');

function toggleLikeIcon(button, currentlyLiked) {
    const icon = button.querySelector('.icon-like');
    if (currentlyLiked) {
        icon.setAttribute('fill', 'none');
        icon.setAttribute('stroke', 'currentColor');
        icon.classList.remove('text-red-500');
        icon.classList.add('text-gray-400');
    } else {
        icon.setAttribute('fill', 'currentColor');
        icon.setAttribute('stroke', 'none');
        icon.classList.add('text-red-500');
        icon.classList.remove('text-gray-400');
    }
}


likeButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        const isLiked = this.getAttribute('data-liked') === 'true';

        fetch('like.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                postId: postId,
                isLiked: isLiked
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toggleLikeIcon(this, data.newStatus); 
                this.setAttribute('data-liked', data.newStatus); 

                const likeCountElement = this.querySelector('.like-count');
                let currentCount = parseInt(likeCountElement.innerText, 10);
                likeCountElement.innerText = data.newStatus ? currentCount + 1 : currentCount - 1;  
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
