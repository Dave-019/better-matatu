<div class="w-full max-w-2xl md:w-3/4 mx-auto mt-4 px-4 flex items-center justify-between">
  <div class="relative flex-2">
    <!-- Search bar -->
    <div class="flex items-center gap-4">
      <input id="searchInput" class="input input-bordered w-full" type="text" placeholder="Search for a matatu, SACCO, or driver" role="combobox" aria-expanded="false" />
      <button id="searchButton" class="btn rounded-box btn-soft btn-warning" aria-haspopup="dialog" aria-expanded="false" aria-controls="slide-up-animated-modal" data-overlay="#slide-up-animated-modal" type="button">
        <span class="icon-[tabler--search] text-base-content text-2xl"></span>
      </button>
    </div>
  </div>

  <!-- Report Button -->
  <a href="./pages/matatus.php" class="btn btn-soft btn-error">Report</a>
</div>


<div id="slide-up-animated-modal" class="overlay modal overlay-open:opacity-100 hidden" role="dialog" tabindex="-1">
  <div class="overlay-animation-target modal-dialog overlay-open:mt-4 overlay-open:opacity-100 overlay-open:duration-500 mt-12 transition-all ease-out" >
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Search results</h3>
        <button type="button" class="btn btn-text btn-circle btn-sm absolute end-3 top-3" aria-label="Close" data-overlay="#slide-up-animated-modal">
          <span class="icon-[tabler--x] size-4"></span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-soft btn-warning" data-overlay="#slide-up-animated-modal">
          Close
        </button>
       
      </div>
    </div>
  </div>
</div>
<script>
document.getElementById("searchButton").addEventListener("click", function() {
    let query = document.getElementById("searchInput").value.trim();
    let modalBody = document.querySelector(".modal-body");

    if (query.length < 3) {
        modalBody.innerHTML = "<p class='text-red-500'>Please enter at least 3 characters to search.</p>";
        document.getElementById("slide-up-animated-modal").classList.remove("hidden");
        return;
    }

    fetch(`./pages/search.php?query=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) throw new Error("Invalid response from server");
            return response.json();
        })
        .then(data => {
            modalBody.innerHTML = ""; // Clear previous results

            if (data.length > 0) {
                data.forEach(item => {
                    let div = document.createElement("div");
                    div.classList.add("p-2", "border-b");
                    div.innerHTML = `<strong class="text-blue-600">${item.type.toUpperCase()}</strong>: ${item.name}`;
                    modalBody.appendChild(div);
                });
            } else {
                modalBody.innerHTML = "<p class='text-gray-500'>No results found.</p>";
            }

            document.getElementById("slide-up-animated-modal").classList.remove("hidden");
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            modalBody.innerHTML = "<p class='text-red-500'>Error fetching search results.</p>";
            document.getElementById("slide-up-animated-modal").classList.remove("hidden");
        });
});

// Close modal when clicking close button
document.querySelectorAll(".close-modal").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("slide-up-animated-modal").classList.add("hidden");
    });
});
</script>
