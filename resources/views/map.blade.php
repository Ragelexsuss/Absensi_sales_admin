@extends('layout.master')
@push('styles')
    <!-- Pastikan Alpine.js dan Maplibre CSS sudah dimuat -->
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v1.2.0/maptiler-sdk.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        .map-container {
            position: relative;
            height: 100vh;
            width: 100%;
        }
        .sidebar {
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: white;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            z-index: 1;
            overflow-y: auto;
            padding: 20px;
        }

        .location-item {
            padding: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .location-item:hover {
            background-color: #f5f5f5;
        }

        .location-item.active {
            background-color: #e3f2fd;
        }

        .marker {
            background-image: url('https://docs.maptiler.com/sdk-js/assets/pin.png');
            background-size: cover;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Arial', sans-serif;
        }
    </style>
@endpush

@section('content')
    <div class="map-container">
        <div id="map"></div>
        <div class="sidebar">
            <h2>Daftar Lokasi</h2>
            <div id="location-list">
                @foreach($lokasis as $lokasi)
                    <div class="location-item"
                         data-id="{{ $lokasi->id_lokasi }}"
                         data-lat="{{ $lokasi->latitude }}"
                         data-lng="{{ $lokasi->longitude }}">
                        <h3>{{ $lokasi->namaToko }}</h3>
                        <p>{{ $lokasi->address }}</p>
                        <small>
                            Status: {{ $lokasi->status ? 'Aktif' : 'Non-Aktif' }} |
                            Radius: {{ $lokasi->radius }}m
                        </small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://kit.fontawesome.com/d074033519.js" crossorigin="anonymous"></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v1.2.0/maptiler-sdk.umd.min.js"></script>

    <script>
        // Initialize the map
        maptilersdk.config.apiKey = '5Ga1ljdidMlYo8nBwyJS';
        const map = new maptilersdk.Map({
            container: 'map',
            style: maptilersdk.MapStyle.STREETS,
            center: [106.8272, -6.1754], // Default to Jakarta center
            zoom: 12
        });

        // Wait for map to load
        map.on('load', function() {
            // Add markers for each location
            @foreach($mapData as $lokasi)
            const marker{{ $loop->index }} = new maptilersdk.Marker()
                .setLngLat([{{ $lokasi['longitude'] }}, {{ $lokasi['latitude'] }}])
                .addTo(map);

            // Add click event to marker
            marker{{ $loop->index }}.getElement().addEventListener('click', () => {
                focusOnLocation({{ $lokasi['longitude'] }}, {{ $lokasi['latitude'] }}, '{{ $lokasi['id'] }}');
            });

            // Add popup to marker
            const popup{{ $loop->index }} = new maptilersdk.Popup({ offset: 25 })
                .setHTML(`
                        <h3>{{ $lokasi['namaToko'] }}</h3>
                        <p>{{ $lokasi['address'] }}</p>

`);

            marker{{ $loop->index }}.setPopup(popup{{ $loop->index }});
            @endforeach

            // Add click events to sidebar items
            document.querySelectorAll('.location-item').forEach(item => {
                item.addEventListener('click', function() {
                    const lat = parseFloat(this.dataset.lat);
                    const lng = parseFloat(this.dataset.lng);
                    const id = this.dataset.id;

                    focusOnLocation(lng, lat, id);
                });
            });

            // Function to focus on a location
            function focusOnLocation(lng, lat, id) {
                // Fly to the location
                map.flyTo({
                    center: [lng, lat],
                    zoom: 15,
                    essential: true
                });

                // Highlight the sidebar item
                document.querySelectorAll('.location-item').forEach(item => {
                    item.classList.remove('active');
                    if (item.dataset.id === id) {
                        item.classList.add('active');
                        item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });
            }
        });
    </script>
@endpush
