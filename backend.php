<?php
// PHP Configuration: Set error reporting for development (optional, but useful)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the variable to hold the processing status/message
$message = "";
$success = false;

// Check if the form was submitted using the 'stone' button value
if (isset($_POST['stone']) && $_POST['stone'] === 'run_contact') {
    
    // 1. Sanitize and collect input data
    $name = isset($_POST['Visitor_Name']) ? htmlspecialchars(trim($_POST['Visitor_Name'])) : 'N/A';
    $email = isset($_POST['Visitor_Email']) ? htmlspecialchars(trim($_POST['Visitor_Email'])) : 'N/A';
    $service = isset($_POST['Service_Needed']) ? htmlspecialchars(trim($_POST['Service_Needed'])) : 'N/A';
    // Nationality value is 'rwanda', 'kenya', etc.
    $nationality = isset($_POST['Visitor_Nationality']) ? htmlspecialchars(trim($_POST['Visitor_Nationality'])) : 'Not Selected';
    
    // CRITICAL FIX: The confirmation status must be 'Confirmed' ONLY if both
    // 1. Nationality is explicitly 'rwanda' AND 
    // 2. The confirmation checkbox 'is_rwandan' is checked.
    $is_rwandan_confirmed = ($nationality === 'rwanda' && isset($_POST['rwanda'])) 
        ? 'Confirmed (Rwanda Citizen & Checkbox Checked)' 
        : 'Not Confirmed (Confirmation Criteria Not Met)';

    // 2. Simulate processing (In a real app, this is where you would save to a DB or send an email)
    if ($name !== 'N/A' && $email !== 'N/A') {
        $success = true;
        
        // Construct the successful processing message
        $message = "
            <h3 class='text-2xl font-bold text-green-600 mb-4'>SUCCESS! Request Received.</h3>
            <p class='text-gray-700 mb-6'>Thank you, <strong>$name</strong>, for reaching out! Your collaboration request has been successfully processed.</p>
            
            <div class='bg-green-50 p-6 rounded-lg border border-green-200'>
                <h4 class='font-semibold text-green-700 mb-2'>SUMMARY OF DATA PROCESSED:</h4>
                <ul class='list-disc list-inside text-sm text-gray-700 space-y-2'>
                    <li><strong>Name:</strong> $name</li>
                    <li><strong>Email:</strong> $email</li>
                    <li><strong>Nationality:</strong> " . ucfirst($nationality) . "</li>
                    <li><strong>Rwandan Confirmation:</strong>$rwanda</li>
                    <li><strong>Service/Collaboration Description:</strong> 
                        <p class='mt-1 italic p-2 bg-white rounded-md border border-gray-100'>$service</p>
                    </li>
                </ul>
            </div>
            <p class='mt-6 text-gray-500 text-sm'>
                Note: In a live environment, this data would be saved to a database or forwarded via email.
            </p>
        ";
    } else {
        $message = "<h3 class='text-2xl font-bold text-red-600 mb-4'>ERROR! Missing Data.</h3><p class='text-gray-700'>Please ensure all required fields are filled out correctly.</p>";
    }

} else {
    // Handle direct access to the PHP file without form submission
    $message = "<h3 class='text-2xl font-bold text-yellow-600 mb-4'>Notice:</h3><p class='text-gray-700'>This page is designed to process form submissions. Please return to the <a href='website.html' class='text-indigo-600 hover:text-indigo-800'>website</a> to submit your request.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Submission Result</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="max-w-xl w-full p-8 bg-white rounded-xl shadow-2xl text-center">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Collaboration Request Status</h1>
        
        <?php echo $message; ?>

        <a href="website.html" class="mt-8 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150">
            Go Back to Contact Form
        </a>
    </div>

</body>
</html>
