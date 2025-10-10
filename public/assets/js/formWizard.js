const slides = document.querySelectorAll('.slide');
const nav = document.getElementById('wizard-nav');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');
const form = document.getElementById('wizard-form');

let currentSlide = 0;

// cria as bolinhas dinamicamente
slides.forEach(() => {
    const span = document.createElement('span');
    span.classList.add('pending');
    nav.appendChild(span);
});
const navDots = nav.querySelectorAll('span');

// atualiza bolinhas baseado nos valores atuais (útil para edição)
slides.forEach((slide, i) => {
    const inputs = slide.querySelectorAll('input, select, textarea');
    const filled = [...inputs].every(inp => inp.value.trim() !== '');
    
    if (filled) {
        navDots[i].className = 'completed';
    }
});

// mostra o slide atual e foca o primeiro input
function showSlide(n) {
    slides.forEach((slide, idx) => {
        slide.classList.toggle('active', idx === n);
    });

    navDots.forEach(dot => dot.classList.remove('active'));
    navDots[n].classList.add('active');

    prevBtn.style.display = n === 0 ? 'none' : 'inline-block';
    nextBtn.style.display = n === slides.length - 1 ? 'none' : 'inline-block';
    submitBtn.style.display = n === slides.length - 1 ? 'inline-block' : 'none';

    const firstInput = slides[n].querySelector('input, select, textarea');
    if (firstInput) setTimeout(() => firstInput.focus(), 150);

    validateAllRequired();
}

// validação dos campos obrigatórios
function validateAllRequired() {
    const inputs = form.querySelectorAll('input, select, textarea');
    let allValid = true;

    inputs.forEach(input => {
        if (input.required) {
            if (!input.value.trim()) allValid = false;
            if (input.type === 'email' && input.value) {
                const re = /\S+@\S+\.\S+/;
                if (!re.test(input.value)) allValid = false;
            }
        }
    });

    submitBtn.disabled = !allValid;
    submitBtn.style.cursor = allValid ? 'pointer' : 'not-allowed';
}

// feedback em tempo real e atualização de bolinhas
slides.forEach((slide, i) => {
    const inputs = slide.querySelectorAll('input, select, textarea');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            let valid = true;

            inputs.forEach(inp => {
                inp.classList.remove('invalid-input');
                if (inp.required && !inp.value.trim()) valid = false;
                if (inp.type === 'email' && inp.value) {
                    const re = /\S+@\S+\.\S+/;
                    if (!re.test(inp.value)) valid = false;
                }
            });

            // atualiza bolinha
            if (valid && [...inputs].some(inp => inp.value.trim())) {
                navDots[i].className = 'completed';
            } else if ([...inputs].some(inp => inp.value.trim())) {
                navDots[i].className = 'invalid';
            } else {
                navDots[i].className = 'pending';
            }

            validateAllRequired();
        });

        // avanço com Enter
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (currentSlide < slides.length - 1) {
                    currentSlide++;
                    showSlide(currentSlide);
                } else if (!submitBtn.disabled) {
                    form.requestSubmit();
                }
            }
        });
    });
});

// navegação manual
nextBtn.addEventListener('click', () => {
    if (currentSlide < slides.length - 1) {
        currentSlide++;
        showSlide(currentSlide);
    }
});

prevBtn.addEventListener('click', () => {
    if (currentSlide > 0) {
        currentSlide--;
        showSlide(currentSlide);
    }
});

// validação final no envio
form.addEventListener('submit', (e) => {
    let valid = true;

    slides.forEach((slide, i) => {
        const inputs = slide.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.classList.remove('invalid-input');

            if (input.required && !input.value.trim()) {
                valid = false;
                input.classList.add('invalid-input');
                navDots[i].className = 'invalid';
            } else if (input.type === 'email' && input.value) {
                const re = /\S+@\S+\.\S+/;
                if (!re.test(input.value)) {
                    valid = false;
                    input.classList.add('invalid-input');
                    navDots[i].className = 'invalid';
                }
            }
        });
    });

    if (!valid) {
        e.preventDefault();
        const firstInvalid = document.querySelector('.invalid-input');
        if (firstInvalid) {
            const invalidSlide = [...slides].findIndex(s => s.contains(firstInvalid));
            currentSlide = invalidSlide;
            showSlide(currentSlide);
        }
    }
});

// inicia o wizard
showSlide(currentSlide);
