<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Province and City/Town Picker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --base-color: #f9f7f1;
            /* Light beige for background */
            --secondary-color: #cfd8dc;
            /* Darker olive green for cards */
            --dark-green: #2c3e50;
            /* Dark green for headers */
            --muted-teal: #2ecc71;
            /* Brighter teal for button */
            --hover-teal: #27ae60;
            /* Darker teal on hover */
            --error-color: #e63946;
            /* Soft red for error messages */
            --text-color: #3e2723;
            /* Dark color for text */
            --card-text-color: #2c3e50;
            /* Darker text color for card content */
        }

        body {
            background-color: var(--base-color);
            color: var(--text-color) !important;
            /* Dark color for text */
            font-family: 'Poppins', sans-serif;
        }

        #header-title {
            color: var(--dark-green);
        }

        .container {
            max-width: 600px;
            /* Centered container */
        }

        .card {
            background-color: var(--secondary-color);
            /* Card background */
            border: none;
            /* Remove default border */
            border-radius: 15px;
            /* Rounded corners */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            /* Soft shadow for depth */
        }

        h3,
        h5 {
            color: var(--dark-green);
            /* Set heading colors to dark green */
        }

        .header-icon {
            color: var(--dark-green);
            /* Dark green for icons */
        }

        .selected-address {
            color: var(--text-color) !important;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .selected-address i {
            margin-right: 10px;
            /* Space between icon and text */
        }

        .btn-primary {
            background-color: var(--muted-teal);
            /* Bright teal for button */
            border: none;
            /* Remove default border */
            border-radius: 10px;
            /* Rounded corners */
            color: white;
            /* White text for button */
        }

        .btn-primary:hover {
            background-color: var(--hover-teal);
            /* Darker teal on hover */
        }

        .form-control {
            border-radius: 10px;
            /* Rounded corners for inputs */
            background-color: #fff;
            /* White background for inputs */
            border: 1px solid var(--dark-green);
            /* Dark green border */
        }

        /* Error message styles */
        .error-message {
            color: var(--error-color);
            font-weight: bold;
            /* Bold error messages */
        }

        /* Responsive design adjustments */
        @media (max-width: 768px) {
            .selected-address {
                flex-direction: column;
                /* Stack icons on small screens */
                align-items: flex-start;
                /* Align to the start */
            }

            .selected-address span {
                text-align: left;
                /* Align text to the left */
            }
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h3 id="header-title" class="text-center">Province and City/Town Picker <i class="fas fa-map-marker-alt header-icon"></i></h3>

        <div class="card mb-4">
            <div class="card-body">
                <h5>
                    <i class="fas fa-map-marker province-icon"></i>
                    Province
                </h5>
                <form id="addressForm">
                    <div class="mb-3">
                        <select id="province" class="form-control">
                            <option value="" disabled selected>Select a province</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5>
                        <i class="fas fa-city city-icon"></i>
                        City/Town
                    </h5>
                    <div class="mb-3">
                        <select id="city" class="form-control" disabled>
                            <option value="" disabled selected>Select a city/town</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="submitBtn">Submit <i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-center flex-column align-items-center">
                <h5 class="mt-4">Selected Address Location <i class="fas fa-map-marker-alt"></i> :</h5>
                <p id="selectedAddress" class="selected-address">
                    <span></span>
                </p>
            </div>
        </div>
    </div>

    <script>
        $('#province').change(function() {
            const provinceId = $(this).val();
            $('#city').prop('disabled', true);
            $('#city').empty().append('<option disabled selected>Loading...</option>');

            $.get(`/get_cities/${provinceId}`, function(cities) {
                $('#city').prop('disabled', false).empty().append('<option value="" disabled selected>Select a city/town</option>');
                $.each(cities, function(index, city) {
                    $('#city').append(`<option value="${city.citytown_id}">${city.citytown_name}</option>`);
                });
            });
        });

        $('#submitBtn').click(function() {
            const selectedProvince = $('#province option:selected').text();
            const selectedCity = $('#city option:selected').text();

            // Clear previous validation messages
            $('#selectedAddress span').html('');

            // Validation to check if both selections are made
            if (!selectedProvince || selectedProvince === "Select a province") {
                $('#selectedAddress span').html(`<span class="error-message"><i class="fas fa-exclamation-circle"></i> Please select a province.</span>`);
                return;
            }
            if (!selectedCity || selectedCity === "Select a city/town") {
                $('#selectedAddress span').html(`<span class="error-message"><i class="fas fa-exclamation-circle"></i> Please select a city/town.</span>`);
                return;
            }

            // Update selected address with icons
            $('#selectedAddress span').html(`
                <span class="province"><i class="fas fa-map"></i> ${selectedProvince}</span><br>
                <span class="city"><i class="fas fa-city"></i> ${selectedCity}</span>
            `);
        });
    </script>

</body>

</html>