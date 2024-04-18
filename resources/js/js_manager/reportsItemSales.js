document.addEventListener('DOMContentLoaded', function () {
    var salesData = <?php echo json_encode($salesData); ?>;
    var urlParams = new URLSearchParams(window.location.search);
    var pageFromUrl = urlParams.get('page');
    currentPage = pageFromUrl ? parseInt(pageFromUrl) : 0;
    var itemsPerPage = 7;
    var searchKeyword = new URL(window.location.href).searchParams.get('productSearch');
    var filteredData = salesData; // Initialize with all data
    var selectedProductId = "<?php echo $selectedProductId; ?>";
    // Update the search input field if a search term exists
    if (searchKeyword) {
        document.getElementById('productSearch').value = searchKeyword;
        filteredData = salesData.filter(function (item) {
            return item.product_name.toLowerCase().includes(searchKeyword.toLowerCase());
        });
    }

    function renderTable() {
        var tableBody = document.querySelector('.scrollable-table-body-container table tbody');
        tableBody.innerHTML = ''; // Clear existing table content

        var startItem = currentPage * itemsPerPage;
        var endItem = startItem + itemsPerPage;
        var paginatedItems = filteredData.slice(startItem, endItem);

        paginatedItems.forEach(function (item) {
            var isSelected = item.product_id == selectedProductId ? 'selected-item' : '';
            var row = `<tr id="row-${item.product_id}" class="${isSelected}">
            <td>${item.product_id}</td>
            <td><img src="data:image/jpeg;base64,${item.image}" height="50"  /></td>
            <td>${item.product_name}</td>
            <td>${item.total_units}</td>
            <td>${item.unit_price}</td>
        </tr>`;
            tableBody.innerHTML += row;
        });


        // Attach click event listeners to each row
        paginatedItems.forEach(function (item) {
            document.getElementById(`row-${item.product_id}`).addEventListener('click', function () {
                setSessionProductId(item.product_id);
            });
        });
    }

    renderTable(); // Render the initial table with filter if applicable

    // Attach event listeners for pagination
    document.getElementById('prevPage').addEventListener('click', function () {
        if (currentPage > 0) {
            currentPage--;
            updatePageInUrl(currentPage);
            renderTable();
        }
    });

    document.getElementById('nextPage').addEventListener('click', function () {
        var maxPage = Math.ceil(filteredData.length / itemsPerPage) - 1;
        if (currentPage < maxPage) {
            currentPage++;
            updatePageInUrl(currentPage);
            renderTable();
        }
    });

    function updatePageInUrl(currentPage) {
        var currentUrl = new URL(window.location);
        currentUrl.searchParams.set('page', currentPage);
        window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
    }



    // Filtering functionality
    document.getElementById('productSearch').addEventListener('input', function () {
        // Reset the currentPage to 0 for a new search
        currentPage = 0;

        // Extract the search keyword from the input
        var inputKeyword = this.value.toLowerCase();

        // Filter your dataset based on the new search keyword
        filteredData = salesData.filter(function (item) {
            return item.product_name.toLowerCase().includes(inputKeyword);
        });

        // Update the page in the URL query parameters to 0
        updatePageInUrl(currentPage);

        // Rerender the table with the filtered data starting from the first page
        renderTable();

        // Update the URL without reloading to include the new search term and reset page number
        var currentUrl = new URL(window.location);
        currentUrl.searchParams.set('productSearch', inputKeyword);
        currentUrl.searchParams.set('page', currentPage); // Reflect the reset page number in the URL
        window.history.pushState({ path: currentUrl.toString() }, '', currentUrl.toString());
    });

});


function setSessionProductId(productId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "set_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            console.log("Session set for product ID: " + productId);
            window.location.reload();
        }
    };
    xhr.send("productId=" + productId);
}