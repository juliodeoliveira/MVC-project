
function confirmDeleteImage(img, images) {
    Swal.fire({
        title: "Deseja deletar a imagem?",
        text: "Você não poderá reverter essa ação!",
        icon: "question",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Sim, apagar!",
        cancelButtonText: "Não, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "Imagem deletada com sucesso!",
                showConfirmButton: false,
                timer: 1500
            });

            img.remove();
    
            images.forEach((img, index) => {
                if (img.src === this.src) {
                    currentIndex = index;
                }
            });

        }
    }).then(() => {
        $.ajax({
            url: 'http://localhost:5500/process-photo',
            type: 'POST',
            data: { imageSrc: img.src, job: "delete" },
            success: function(response) {
                // console.log(response);
                
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', status, error);
            }
        });
    });
}


document.addEventListener('DOMContentLoaded', function() {
    function initCarousel(carousel) {
        const images = carousel.querySelectorAll('.carousel-images img');
        let maxHeight = 0;

        // add click event for each image
        images.forEach(img => {
            img.onload = function() {
                if (img.height > maxHeight) {
                    maxHeight = img.height;
                    carousel.style.height = maxHeight + 'px';
                }
            }

            img.addEventListener('click', function() {
                confirmDeleteImage(img, images);
            });
        });

        let currentIndex = 0;
        const totalImages = images.length;
        const prevButton = carousel.querySelector('.prev');
        const nextButton = carousel.querySelector('.next');

        function updateCarousel() {
            const offset = -currentIndex * 600; // Ajuste conforme a largura do carrossel
            carousel.querySelector('.carousel-images').style.transform = `translateX(${offset}px)`;
        }

        prevButton.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? totalImages - 1 : currentIndex - 1;
            updateCarousel();
        });

        nextButton.addEventListener('click', () => {
            currentIndex = (currentIndex === totalImages - 1) ? 0 : currentIndex + 1;
            updateCarousel();
        });
    }

    document.querySelectorAll('.carousel').forEach(initCarousel);
});