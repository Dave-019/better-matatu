<?php
session_start();
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT sacco_id FROM users WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$saccoId = $userData['sacco_id'] ?? null;

if (!$saccoId) {
    die("Sacco not found for this user.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['name'] ?? '');
    $phoneNumber = trim($_POST['phone'] ?? '');
    $licenseNumber = trim($_POST['license'] ?? '');
    $registrationNumber = trim($_POST['registration_number'] ?? '');
    $routeNumber = trim($_POST['route_number'] ?? '');
    $seatCapacity = trim($_POST['seat_capacity'] ?? '');

    if (empty($fullName) || empty($phoneNumber) || empty($licenseNumber) || empty($registrationNumber) || empty($routeNumber) || empty($seatCapacity)) {
        $error = "All fields are required.";
    } else {
        try {
            $pdo->beginTransaction(); 
                
            
            $stmt = $pdo->prepare("INSERT INTO drivers (name, phone, license_number, sacco_id, safety_score, violation_count, created_at, updated_at) VALUES (?, ?, ?, ?, 100, 0, NOW(), NOW())");
            $stmt->execute([$fullName, $phoneNumber, $licenseNumber, $saccoId]);

            if ($stmt->rowCount() > 0) {
                $driverId = $pdo->lastInsertId();
                
                
                $stmt = $pdo->prepare("INSERT INTO matatus (driver_id, route_number, seat_capacity, sacco_id, reg_num, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, 'active', NOW(), NOW())");
                $stmt->execute([$driverId, $routeNumber, $seatCapacity, $saccoId, $registrationNumber]);

                if ($stmt->rowCount() > 0) {
                    $pdo->commit(); 
                    $success = "Driver and matatu details added successfully.";
                } else {
                    $pdo->rollBack(); 
                    $error = "Failed to add matatu details.";
                }
            } else {
                $pdo->rollBack(); 
                $error = "Failed to add driver details.";
            }
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack(); 
            }
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>


<h1 class="text-2xl font-semi-bold">Add members</h1>
            <div class="fixed bottom-0 left-0 w-full flex justify-center mb-4">
                <div class="max-w-md w-full px-4">
                    <?php if (isset($error)): ?>
                        <div class="bg-error border border-red-400 text-error-content px-4 py-3 rounded relative mb-4" id="error-message">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <script>
                            setTimeout(function() {
                                document.getElementById('error-message').remove();
                            }, 2000);
                        </script>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="bg-success border border-green-400 text-success-content px-4 py-3 rounded relative mb-4" id="success-message">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                        <script>
                            setTimeout(function() {
                                document.getElementById('success-message').remove();
                            }, 2000);
                        </script>
                    <?php endif; ?>
                </div>
            </div>
           <div class= "p-6 mx-auto my-6 max-w-4xl border border-info/20 rounded-box ">
                        
                            <!-- Stepper -->
                <div data-stepper="" class=" flex w-full items-start gap-10 0p-4  max-sm:flex-wrap max-sm:justify-center" id="wizard-validation" >
                    <!-- Stepper Nav -->
                    <ul class="relative flex  sm:flex-col gap-y-2">
                    <li class="group flex flex-1 flex-col items-center" data-stepper-nav-item='{ "index": 1 }'>
                        <span class="min-h-7.5 group inline-flex flex-col items-center gap-2 align-middle text-sm">
                        <span class="stepper-active:bg-primary stepper-active:shadow stepper-active:text-primary-content stepper-success:bg-primary stepper-success:shadow stepper-success:text-primary-content stepper-error:bg-error stepper-error:text-error-content stepper-completed:bg-success stepper-completed:group-focus:bg-success bg-base-200/50 text-base-content group-focus:bg-base-content/20 size-7.5 flex flex-shrink-0 items-center justify-center rounded-full font-medium" >
                            <span class="stepper-success:hidden stepper-error:hidden stepper-completed:hidden text-sm">1</span>
                            <span class="icon-[tabler--check] stepper-success:block hidden size-4 flex-shrink-0"></span>
                            <span class="icon-[tabler--x] stepper-error:block hidden size-4 flex-shrink-0"></span>
                        </span>
                        <span class="text-base-content text-nowrap font-medium">Drivers Details</span>
                        </span>
                        <div class="stepper-success:bg-primary stepper-completed:bg-success bg-base-content/20 mt-2 h-8 w-px group-last:hidden" ></div>
                    </li>
                    <li class="group flex flex-1 flex-col items-center" data-stepper-nav-item='{ "index": 2 }'>
                        <span class="min-h-7.5 group inline-flex flex-col items-center gap-2 align-middle text-sm">
                        <span class="stepper-active:bg-primary stepper-active:shadow stepper-active:text-primary-content stepper-success:bg-primary stepper-success:shadow stepper-success:text-primary-content stepper-error:bg-error stepper-error:text-error-content stepper-completed:bg-success stepper-completed:group-focus:bg-success bg-base-200/50 text-base-content group-focus:bg-base-content/20 size-7.5 flex flex-shrink-0 items-center justify-center rounded-full font-medium" >
                            <span class="stepper-success:hidden stepper-error:hidden stepper-completed:hidden text-sm">2</span>
                            <span class="icon-[tabler--check] stepper-success:block hidden size-4 flex-shrink-0"></span>
                            <span class="icon-[tabler--x] stepper-error:block hidden size-4 flex-shrink-0"></span>
                        </span>
                        <span class="text-base-content text-nowrap font-medium">Matatus Info</span>
                        </span>
                        <div class="stepper-success:bg-primary stepper-completed:bg-success bg-base-content/20 mt-2 h-8 w-px group-last:hidden" ></div>
                    </li>
             
                    <!-- End Item -->
                    </ul>
                    <!-- End Stepper Nav -->
                
                    <!-- Stepper Content -->
                    <form method="Post" action="sacco.php" id="wizard-validation-form" class="form-validate w-full p-3" novalidate>
                    <!-- Account Details -->
                    <div id="account-details-validation" class="space-y-5" data-stepper-content-item='{ "index": 1 }'>
                               <!-- Driver Details -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="mb-5">
                                <label for="name" class="mb-3 block text-base font-medium "> Full Name </label>
                                <input type="text" name="name" id="name" placeholder="Full Name"
                                    class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
                    
                            <div class="mb-5">
                                <label for="phone" class="mb-3 block text-base font-medium  "> Phone Number </label>
                                <input type="text" name="phone" id="phone" placeholder="Enter phone number"
                                     class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
                    
                            <div class="mb-5">
                                <label for="license" class="mb-3 block text-base font-medium "> License Number </label>
                                <input type="text"  name="license" id="license" placeholder="Enter license number"
                                  class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
                   
                    
                        </div>

                    </div>
                    <!-- End Account Details -->
                    <!-- Personal Info -->
                    <div id="personal-info-validation" class="space-y-5" data-stepper-content-item='{ "index": 2 }' style="display: none" >
                   
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Matatu Details -->
                            <div class="mb-5">
                                <label for="registration_number" class="mb-3 block text-base font-medium"> Registration Number </label>
                                <input type="text" name="registration_number" id="registration_number" placeholder="Enter registration number"
                                class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
                    
                            <div class="mb-5">
                                <label for="route_number" class="mb-3 block text-base font-medium"> Route Number </label>
                                <input type="text" name="route_number" id="route_number" placeholder="Enter route number"
                                class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
                    
                            <div class="mb-5">
                                <label for="seat_capacity" class="mb-3 block text-base font-medium"> Seat Capacity </label>
                                <input type="number" name="seat_capacity" id="seat_capacity" placeholder="Enter seat capacity"
                                class="w-full rounded-md border  py-3 px-6 text-base font-medium  outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                            </div>
    
                      
                        </div>
                    </div>
               \
                    <div class="mt-5 flex items-center justify-between gap-x-2">
                        <button type="button" class="btn btn-primary btn-prev max-sm:btn-square" data-stepper-back-btn="">
                        <span class="icon-[tabler--chevron-left] text-primary-content size-5 rtl:rotate-180"></span>
                        <span class="max-sm:hidden">Back</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-next max-sm:btn-square" data-stepper-next-btn="">
                        <span class="max-sm:hidden">Next</span>
                        <span class="icon-[tabler--chevron-right] text-primary-content size-5 rtl:rotate-180"></span>
                        </button>
                        <button type="submit" class="btn btn-primary" data-stepper-finish-btn="" style="display: none">Finish</button>
                    
                    </div>
                    <!-- End Button Group -->
                    </form>
                    <!-- End Stepper Content -->
                </div>
                <!-- End Stepper -->
                </div>
                <script>
    document.addEventListener('DOMContentLoaded', function() {
      const notyf = new Notyf();

      <?php if ($error): ?>
        notyf.error('<?php echo htmlspecialchars($error); ?>');
      <?php endif; ?>

      <?php if ($success): ?>
        notyf.success('<?php echo htmlspecialchars($success); ?>');
      <?php endif; ?>
    });
  </script>