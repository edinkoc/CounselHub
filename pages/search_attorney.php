<?php

require_once("../../backend/connect.php");

$query = "SELECT * FROM attorney";

$selectedFilters = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filter'])) {
    $specialization = isset($_GET['specialization']) ? $_GET['specialization'] : '';
    $experience = isset($_GET['experience']) ? $_GET['experience'] : '';

    $query .= " WHERE 1=1";
    if (!empty($specialization)) {
        $query .= " AND specialization = '" . $specialization . "'";
        $selectedFilters[] = $specialization;
    }
    if (!empty($experience)) {
        $query .= " AND experience >= " . intval($experience);
        $selectedFilters[] = $experience . "+ years experience";
    }
}

$records = myQuery($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Attorneys</title>
    <link rel="stylesheet" href="../css/search_attorney.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #f9f6f4, #e0d6cf);
            color: #333;
        }

        .top-bar {
            width: 100%;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 20px;
        }

        .top-bar h1 {
            margin: 0;
            font-size: 1.8rem;
            color: #a8896c;
        }

        
        .filter-btn {
            background-color: #a8896c;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-right: 30px; 
            margin-top: -5px; 
        }

        .filter-btn:hover {
            background-color: #8a705b;
            transform: scale(1.05);
        }

        .header-space {
            margin-top: 80px; 
        }

        .filter-summary {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        .filter-summary span {
            font-weight: bold;
            color: #a8896c;
        }

        .attorney-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            justify-items: center;
        }

        .attorney-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s;
            border: 2px solid #eae4df;
            width: 260px;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .attorney-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            background: #fefdfc;
        }

        .attorney-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 3px solid #ddd;
            object-fit: cover;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .attorney-card img:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .attorney-card h3 {
            color: #333;
            font-size: 1.2em;
            margin: 10px 0;
            transition: color 0.3s;
        }

        .attorney-card h3:hover {
            color: #a8896c;
        }

        .attorney-card p {
            margin: 5px 0;
            font-size: 0.95em;
            color: #555;
        }

        .filter-form {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 80px;
            right: 30px;
            display: none;
            transition: opacity 0.3s ease, transform 0.3s ease;
            z-index: 10;
        }

        .filter-form.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .filter-form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        .filter-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .filter-form button {
            background-color: #a8896c;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .filter-form button:hover {
            background-color: #8a705b;
        }

        .filter-form a {
            color: red;
            text-align: center;
            display: block;
            margin-top: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .filter-form a:hover {
            color: darkred;
        }

        @media (max-width: 1024px) {
            .attorney-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .attorney-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .attorney-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        function toggleFilterForm() {
            const filterForm = document.getElementById('filter-form');
            filterForm.classList.toggle('active');
        }
    </script>
</head>
<body>
    <?php include_once "../../components/customer/header/navBar.php"; ?>
    
    <div class="top-bar">
        <h1>Our Attorneys</h1>
        <button class="filter-btn" onclick="toggleFilterForm()">Filter</button>
    </div>

    <div class="header-space"></div>

    <?php if (!empty($selectedFilters)): ?>
        <div class="filter-summary">
            Showing results for: 
            <span><?php echo implode(", ", $selectedFilters); ?></span>
        </div>
    <?php endif; ?>

    <form id="filter-form" class="filter-form" method="GET" action="search_attorney.php">
        <label for="specialization">Specialization:</label>
        <select name="specialization">
            <option value="">All Specializations</option>
            <option value="Corporate Law">Corporate Law</option>
            <option value="Criminal Law">Criminal Law</option>
            <option value="Family Law">Family Law</option>
            <option value="Tax Law">Tax Law</option>
            <option value="Immigration Law">Immigration Law</option>
        </select>

        <label for="experience">Experience (Years):</label>
        <select name="experience">
            <option value="">All</option>
            <option value="5">5+ Years</option>
            <option value="10">10+ Years</option>
        </select>

        <button type="submit" name="filter" value="1">Apply Filters</button>
        <a href="search_attorney.php">Clear Filters</a>
    </form>

    <div class="attorney-container">

<?php

$attorney_images = [
    1 => 'images/attorneys/attorney_woman1.jpg',
    2 => 'images/attorneys/attorney_man1.jpg',
    3 => 'images/attorneys/attorney_woman2.jpg',
    4 => 'images/attorneys/attorney_woman3.jpg',
    5 => 'images/attorneys/attorney_woman4.jpg',
    6 => 'images/attorneys/attorney_man2.jpg',
    7 => 'images/attorneys/attorney_woman5.jpg',
    8 => 'images/attorneys/attorney_man4.jpg',
    9 => 'images/attorneys/attorneywoman6.jpg',
    10 => 'images/attorneys/attorney_man5.jpg',
];

if ($records->num_rows > 0) {
    foreach ($records as $index => $row) {
        $image_url = isset($attorney_images[$index + 1]) ? $attorney_images[$index + 1] : 'images/default-avatar.png';
        echo "<div class='attorney-card'>
                <a href='attorney_detail.php?id={$row['attorney_id']}' style='text-decoration: none; color: inherit;'>
                    <img src='{$image_url}' alt='{$row['attorney_firstname']} {$row['attorney_lastname']}'>
                    <h3>{$row['attorney_firstname']} {$row['attorney_lastname']}</h3>
                    <p><strong>Specialization:</strong> {$row['specialization']}</p>
                    <p><strong>Experience:</strong> {$row['experience']} years</p>
                </a>
            </div>";
    }
} else {
    echo "<p>No attorneys found for the given criteria.</p>";
}

?>
    </div>
    
    <?php include_once "../../frontend/components/customer/footer/footer.php"; ?>
    
</body>
</html>