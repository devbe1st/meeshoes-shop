const productsPerPage = 15;
const allProducts = document.querySelectorAll('.product');
const totalPages = Math.ceil(allProducts.length / productsPerPage);
const paginationContainer = document.getElementById('pagination-buttons');

let currentPage = 1;

function showPage(pageNumber) {
    currentPage = pageNumber;
    const startIndex = (pageNumber - 1) * productsPerPage;
    const endIndex = startIndex + productsPerPage;
    allProducts.forEach((product, index) => {
        if (index >= startIndex && index < endIndex) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
    renderPaginationButtons();
}

function renderPaginationButtons() {
    paginationContainer.innerHTML = '';

    if (totalPages > 1) { // Only render pagination buttons if there is more than one page
        let startPage, endPage;
        if (totalPages <= 5) {
            startPage = 1;
            endPage = totalPages;
        } else {
            if (currentPage <= 3) {
                startPage = 1;
                endPage = 5;
            } else if (currentPage + 2 >= totalPages) {
                startPage = totalPages - 4;
                endPage = totalPages;
            } else {
                startPage = currentPage - 2;
                endPage = currentPage + 2;
            }
        }

        if (currentPage > 1) {
            const backButton = createButton('Back', currentPage - 1);
            paginationContainer.appendChild(backButton);
        }

        for (let i = startPage; i <= endPage; i++) {
            const pageButton = createButton(i, i);
            paginationContainer.appendChild(pageButton);
        }

        if (currentPage < totalPages) {
            const nextButton = createButton('Next', currentPage + 1);
            paginationContainer.appendChild(nextButton);
        }
    }
}

function createButton(text, pageNumber) {
    const button = document.createElement('button');
    button.innerText = text;
    button.addEventListener('click', () => showPage(pageNumber));
    return button;
}

showPage(1);