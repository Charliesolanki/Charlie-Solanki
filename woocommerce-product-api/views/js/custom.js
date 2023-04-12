async function getProducts(number) {
    let url = theme_data.home_url+'/wp-json/woocommerce-product-api/v1/products/'+number;
    try {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
}

async function getProductsCount(number) {
    let counturl = theme_data.home_url+'/wp-json/woocommerce-product-api/v1/products-list/';
    try {
        let countres = await fetch(counturl);
        return await countres.json();
    } catch (error) {
        console.log(error);
    }
}

async function renderProducts(page_number) {
    let products = await getProducts(page_number);
    let html = '';
    products.forEach(product => {
        let htmlSegment = `
                    <div class="single-product col-md-3">
                            <div class="">
                                <a href="${product.productLink}">
                                    <img width='200px' src="${product.imageUrl}" >
                                    <h2>${product.name} </h2>
                                    </a>
                                </div>
                                </div> `;
        html += htmlSegment;
    });

    let productscount = await getProductsCount();
        var pagination_array = {
            total: productscount.count,
            per_page: 5,    
            current_page: 1, 
            last_page: Math.ceil(productscount.count / 5),
            from: ((1 -1) * 5) + 1,
            to: 1  * 5
        };

        let html_page = '<div class="pagination_parent"><ul class="pagination">';
            for (let i = 1; i <= pagination_array.last_page; i++) {
                let pagination = 
                    `<li class="page-item"><a href="javascript:void(0)" onclick="renderProducts(${i})">${i}</a></li>`;
                html_page += pagination;
            }
            html_page += '</ul></div>';
        let container = document.querySelector('.product-listing');
        container.innerHTML = html;
        let pagination_con = document.querySelector('.pagination_inner');
        pagination_con.innerHTML = html_page;
}

renderProducts(1);