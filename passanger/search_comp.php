<div class="w-full max-w-2xl md:w-3/4 mx-auto mt-4 px-4 flex items-center justify-between">
  <div class="relative flex-2">
    <!-- Search bar -->
    <div class="flex items-center gap-2">
      <input id="searchInput" class="input input-bordered w-full" type="text" placeholder="Search for a matatu, SACCO, or driver" role="combobox" aria-expanded="false" />
      <button id="searchButton" class="btn rounded-box btn-soft btn-warning" aria-haspopup="dialog" aria-expanded="false" aria-controls="slide-up-animated-modal" data-overlay="#slide-up-animated-modal" type="button">
        <span class="icon-[tabler--search] text-warning size-6"></span>
      </button>
    </div>
  </div>

  <!-- Report Button -->
<div class="flex items-center gap-4">
<a href="../pages/report.php" class="hidden sm:flex btn btn-soft  btn-warning">Report<span class="icon-[tabler--exclamation-circle] size-6"></span> </a>
<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
    <button id="dropdown-scrollable" type="button" class="dropdown-toggle " aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
        <div class="avatar w-10 h-10 rounded-full bg-white flex items-center justify-center text-primary text-3xl font-bold ">
            <?php echo $initial; ?>
        </div>
    </button>
    <ul class="dropdown-menu dropdown-open:opacity-100 hidden min-w-60" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-avatar">
    
        <li>
            <a class="dropdown-item" href="out.php">
                <span class="icon-[tabler--login] text-error size-6"></span>
                Sign-out
            </a>
        </li>
        <li class="dropdown-footer gap-2 sm:hidden">
            <a href="../pages/report.php" class="w-full btn btn-soft btn-error"> Report <span class="icon-[tabler--exclamation-circle] size-6"></span> </a>
        </li>
    </ul>
</div>
  
</div>
</div>

<div id="slide-up-animated-modal" class="overlay modal overlay-open:opacity-100 hidden" role="dialog" tabindex="-1">
  <div class="overlay-animation-target modal-dialog overlay-open:mt-4 overlay-open:opacity-100 overlay-open:duration-500 mt-12 transition-all ease-out">
  <div class="modal-content bg-white shadow-lg rounded-lg">
  <div class="modal-header">
    <h3 class="modal-title text-gray-500">Search results</h3>
    <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#slide-up-animated-modal">
      <span class="icon-[tabler--x] size-4 text-gray-500"></span>
    </button>
  </div>
  <div class="modal-body ">
    
  </div>
  <div class="modal-footer">
    <button type="button" class="btn  btn-soft btn-warning" data-overlay="#slide-up-animated-modal">
      Close
    </button>
  </div>
</div>

  </div>
</div>
<script>
  document.getElementById("searchButton").addEventListener("click", function () {
        const query = document.getElementById("searchInput").value.trim();
        const modalBody = document.querySelector(".modal-body");
      // damn ,,i need to be serious man 😂😂 -->
        if (query.length < 3) {
            modalBody.innerHTML = "<p class='text-red-500'>Please enter at least 3 characters to search.</p>";
            document.getElementById("slide-up-animated-modal").classList.remove("hidden");
            return;
        }

        fetch(`../services/search.php?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) throw new Error("Invalid response from server");
                return response.json();
            })
            .then(data => {
                modalBody.innerHTML = ""; 

                if (data.length > 0) {
                    data.forEach(item => {
                        const card = document.createElement("div");
                        card.classList.add("bg-white", "p-4", "rounded-box", "mb-4", "border", "car", "border-gray-500/80");
                        card.innerHTML = `
                            <h4 class="text-xl font-semibold text-gray-500 mb-2">${item.type.toUpperCase()}</h4>
                            <p class="text-md font-medium mb-2 text-gray-500">${item.identifier}</p>
                            <div class="text-sm text-gray-500">
                              ${item.info1 ? `<div><strong>Info1:</strong> ${item.info1}</div>` : ''}
                              ${item.info2 ? `<div><strong>Info2:</strong> ${item.info2}</div>` : ''}
                              ${item.info3 ? `<div><strong>Info3:</strong> ${item.info3}</div>` : ''}
                            </div>
                        `;
                        card.addEventListener("click", function () {
                            window.location.href = `../pages/driver.php?id=${item.id}&type=${encodeURIComponent(item.type)}`;
                        });
                        modalBody.appendChild(card);
                    });
                } else {
                    modalBody.innerHTML = "<p class='text-gray-500'>No results found.</p>";
                }

                document.getElementById("slide-up-animated-modal").classList.remove("hidden");
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                modalBody.innerHTML = "<p class='text-error-500'>Error fetching search results.</p>";
                document.getElementById("slide-up-animated-modal").classList.remove("hidden");
            });
    });

</script>


