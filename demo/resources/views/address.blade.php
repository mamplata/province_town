<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Province and City/Town Picker - Aquatic Fantasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --base-color: #e0f7fa;
            /* Light aquatic blue for background */
            --secondary-color: #80deea;
            /* Brighter turquoise for cards */
            --dark-blue: #004d40;
            /* Darker aquatic green for headers */
            --muted-aqua: #00bcd4;
            /* Muted aqua for buttons */
            --hover-aqua: #00838f;
            /* Darker aqua on hover */
            --coral-color: #ff7043;
            /* Brighter coral for error messages */
            --text-color: #00332a;
            /* Darker green for text */
            --card-text-color: #004d40;
            /* Darker text for card content */
        }

        body {
            background-color: var(--base-color);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
        }

        #header-title {
            color: var(--dark-blue);
        }

        .container {
            max-width: 600px;
        }

        .card {
            background-color: var(--secondary-color);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        h3,
        h5 {
            color: var(--dark-blue);
        }

        .header-icon {
            color: var(--dark-blue);
        }

        .selected-address {
            color: var(--text-color);
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            margin-top: 10px;
        }

        .selected-address i {
            margin-right: 10px;
        }

        .btn-primary {
            background-color: var(--muted-aqua);
            border: none;
            border-radius: 10px;
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--hover-aqua);
        }

        .form-control {
            border-radius: 10px;
            background-color: #fff;
            border: 2px solid var(--dark-blue);
        }

        /* Error message styles */
        .error-message {
            color: var(--coral-color);
            font-weight: bold;
        }

        /* Responsive design adjustments */
        @media (max-width: 768px) {
            .selected-address {
                flex-direction: column;
                align-items: flex-start;
            }

            .selected-address span {
                text-align: left;
            }
        }

        /* Additional fantasy aquatic styles */
        .fantasy-icon {
            color: var(--muted-aqua);
        }

        h5 i {
            color: var(--hover-aqua);
        }

        .container {
            border: 2px solid var(--dark-blue);
            padding: 20px;
            background: linear-gradient(135deg, rgba(0, 188, 212, 0.8) 0%, rgba(128, 222, 234, 0.8) 100%);
        }

        #selectedAddress {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 10px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h3 id="header-title" class="text-center"><strong>Province and City/Town Picker</strong></i></h3>

        <div class="card mb-4">
            <div class="card-body">
                <h5>
                    <i class="fas fa-map-pin"></i>
                    Province
                </h5>
                <form id="addressForm">
                    <div class="mb-3">
                        <select id="province" class="form-control">
                            <option value="" disabled selected>Select a province</option>
                            @foreach ($provinces as $province)
                            <option value="{{ $province->province_name }}">{{ $province->province_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h5>
                        <i class="fas fa-ship"></i>
                        City/Town
                    </h5>
                    <div class="mb-3">
                        <select id="city" class="form-control" disabled>
                            <option value="" disabled selected>Select a city/town</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary w-100" id="submitBtn">Submit <i class="fas fa-paper-plane fantasy-icon"></i></button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-center flex-column align-items-center">
                <h5 class="mt-4">Selected Address Location <i class="fas fa-map-marker-alt fantasy-icon"></i> :</h5>
                <p id="selectedAddress" class="selected-address">
                    <span></span>
                </p>
            </div>
        </div>
    </div>

    <script>
        $('#province').change(function() {
            const provinceName = $(this).val();
            console.log(provinceName);
            $('#city').prop('disabled', true);
            $('#city').empty().append('<option disabled selected>Loading...</option>');

            $.get(`/get_cities/${provinceName}`, function(cities) {
                $('#city').prop('disabled', false).empty().append('<option value="" disabled selected>Select a city/town</option>');
                $.each(cities, function(index, city) {
                    $('#city').append(`<option value="${city.citytown_name}">${city.citytown_name}</option>`);
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
                <span class="city"><i class="fas fa-ship"></i> ${selectedCity}</span>
            `);
        });
    </script>

</body>

</html>