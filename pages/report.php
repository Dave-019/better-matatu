<?php
session_start();
require_once 'config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $passenger_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $car_reg_num = $_POST['car_reg_num'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $details = $_POST['details'];
    $location = $_POST['location'];
    $timestamp = date('Y-m-d H:i:s');

 
    if (empty($passenger_id) || empty($violation_type) || empty($car_reg_num) || empty($description) || empty($details) || empty($location)) {
        $error = "All fields are required.";
    } else {
    
        $targetDir = "../images/";
        $fileName = basename($_FILES["driver_photo"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileType, $allowTypes)) {
            
            if ($_FILES["driver_photo"]["size"] <= 10000000) {
                if (move_uploaded_file($_FILES["driver_photo"]["tmp_name"], $targetFilePath)) {
                    
                    try {
                        
                        $stmt = $pdo->prepare("SELECT id, driver_id FROM matatus WHERE reg_num = :car_reg_num");
                        $stmt->execute(['car_reg_num' => $car_reg_num]);
                        $matatu = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($matatu) {
                            $matatu_id = $matatu['id'];
                            $driver_id = $matatu['driver_id']; 

                            
                            $stmt = $pdo->prepare("INSERT INTO incidents 
                                (passenger_id, matatu_id, driver_id, violation_type, description, details, location, image_path, timestamp) 
                                VALUES (:passenger_id, :matatu_id, :driver_id, :violation_type, :description, :details, :location, :image, :timestamp)");
//will do this update later,,my  😂💔..logic yako ni trash
                            $result = $stmt->execute([
                                'passenger_id' => $passenger_id,
                                'matatu_id' => $matatu_id,
                                'driver_id' => $driver_id, 
                                'violation_type' => $violation_type, 
                                'description' => $description,
                                'details' => $details,
                                'location' => $location,
                                'image' => 'images/' . $fileName,
                                'timestamp' => $timestamp
                            ]);

                            if ($result) {
                                $success = "Incident reported successfully!";
                            } else {
                                $error = "Failed to report incident. Please try again later.";
                            }
                        } else {
                            $error = "Car registration number not found in the system.";
                        }
                    } catch (PDOException $e) {
                        $error = "Database error: " . $e->getMessage();
                    }
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                }
            } else {
                $error = "File size must be less than 10MB.";
            }
        } else {
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Report Form</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="max-w-xl mx-auto p-10 bg-white rounded-box border border-gray-500/30 w-full sm:w-auto">
        <h2 class="text-xl font-bold mb-8 text-gray-900">
            Report an Incident
        </h2>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($success); ?></span>
            </div>
            <?php header ('location:../auth/success.php');  ?>
        <?php endif; ?>
        <form action="report.php" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-box">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="hidden" id="passenger_id" name="passenger_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
                <div class="space-y-2">
                    <label for="car_reg_num" class="text-gray-700">Car Registration Number</label>
                    <input id="car_reg_num" type="text" name="car_reg_num" 
                           class="w-full p-3 rounded-box border border-gray-500/80 text-base-content" 
                           placeholder="Car registration number" required>
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
                        class="w-full p-3 rounded-box border border-gray-500/80 text-base-content"
                        required
                    >
                        <option value="">Choose description</option>
                        <option value="minor">Minor Incident</option>
                        <option value="moderate">Moderate Incident</option>
                        <option value="severe">Severe Incident</option>
                    </select>
                </div>
            </div>
            <div class="space-y-2">
                <label for="violation_type" class="text-gray-700">violation type</label>
                <textarea id="violation_type" name="violation_type" rows="3"
                          class="w-full h-[7rem] p-3 rounded-box border border-gray-500/80 text-base-content" 
                          placeholder="violation type" required></textarea>
            </div>
            <div class="space-y-2">
                <label for="details" class="text-gray-700">Details</label>
                <textarea id="details" name="details" rows="3"
                          class="w-full h-[11rem] p-3 rounded-box border border-gray-500/80 text-base-content" 
                          placeholder="Additional details" required></textarea>
            </div>
            <div class="space-y-2">
                <label for="location" class="text-gray-700">Location</label>
                <input id="location" name="location" type="text" 
                       class="w-full p-3 rounded-box border border-gray-500/80 text-base-content" 
                       placeholder="Incident location" required>
            </div>
            <div class="space-y-2">
                <label for="image" class="text-gray-700">Upload Image</label>
                <div class="flex justify-center mb-4">
                    <div class="w-full sm:w-[500px] relative border-2 border-gray-500/80 border-dashed rounded p-6" id="dropzone">
                        <input type="file" name="driver_photo" class="absolute inset-0 w-full h-full opacity-0 z-50" accept="image/*" required />
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
    <script>
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
