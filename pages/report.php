<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report Form</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="bg-base-100 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-xl mx-auto p-10 bg-white shadow-lg rounded-box border border-gary-200 w-full sm:w-auto">
        <h2 class="text-xl font-bold mb-8 text-gray-900">
            Report an Incident
        </h2>
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-box">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" id="passenger_id" name="passenger_id" value="LOGGED_IN_USER_ID">
                <div class="space-y-2">
                    <label for="car_reg_num" class="text-gray-700">Car Registration Number</label>
                    <input id="car_reg_num" type="text" name="car_reg_num" 
                           class="w-full p-3 rounded-box border border-gary-800 text-base-content" 
                           placeholder="Car registration number">
                </div>
                <div class="space-y-2">
                    <label for="description" class="text-gray-700">Description</label>
                    <select
                        id="description"
                        name="description"
                        data-select='{
                            "placeholder": "Select description",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "advance-select-toggle",
                            "dropdownClasses": "advance-select-menu",
                            "dropdownVerticalFixedPlacement": "bottom",
                            "optionClasses": "advance-select-option selected:active",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"icon-[tabler--check] flex-shrink-0 size-4 text-primary hidden selected:block \"></span></div>",
                            "extraMarkup": "<span class=\"icon-[tabler--caret-up-down] flex-shrink-0 size-4 text-base-content absolute top-1/2 end-3 -translate-y-1/2 \"></span>"
                        }'
                        class="w-full p-3 rounded-box border border-gray text-base-content"
                    >
                        <option value="">Choose description</option>
                        <option value="minor">Minor Incident</option>
                        <option value="moderate">Moderate Incident</option>
                        <option value="severe">Severe Incident</option>
                    </select>
                </div>
            </div>
            <div class="space-y-2">
                <label for="details" class="text-gray-700">Details</label>
                <textarea id="details" name="details" rows="3"
                          class=" w-full h-[11rem] p-3 rounded-box border border-gray text-base-content" 
                          placeholder="Additional details"></textarea>
            </div>
            <div class="space-y-2">
                <label for="location" class="text-gray-700">Location</label>
                <input id="location" name="location" type="text" 
                       class="w-full p-3 rounded-box border border-gray text-base-content" 
                       placeholder="Incident location">
            </div>
            <div class="space-y-2">
                <label for="image" class="text-gray-700">Upload Image</label>
                <div class="flex justify-center mb-4">
                    <div class="w-full sm:w-[500px] relative border-2 border-gray-200 border-dashed rounded p-6" id="dropzone">
                        <input type="file" name="driver_photo" class="absolute inset-0 w-full h-full opacity-0 z-50" required />
                        <div class="text-center">
                            <img class="mx-auto h-12 w-12" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="">
                            <h3 class="mt-2 text-sm font-medium text-gray-700">
                                <span>Drag and drop</span> or <span class="text-blue-500">browse</span> to upload
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>
                        <img src="" class="mt-4 mx-auto max-h-40 hidden" id="preview">
                    </div>
                </div>
            </div>
            <button type="submit" 
                    class="w-full btn btn-soft btn-error rounded-box">
                Report
            </button>
        </form>
    </div>
    <script src="../node_modules/flyonui/flyonui.js"></script>
</body>
</html>

