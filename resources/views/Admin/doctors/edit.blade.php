@extends('Super.layout')

@section('styles')
    <style>
        .profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .profile-header {
            margin-bottom: 2rem;
            text-align: center;
        }
        .profile-header h2 {
            color: #fff;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .card {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(15,23,42,0.30);
        }
        .card-header {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #fff;
            font-size: 1.2rem;
            font-weight: 500;
            padding: 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .card-body {
            padding: 2rem;
            color: #fff;
        }
        .form-label {
            color: #fff !important;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .form-control, .form-select {
            background-color: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px;
            padding: 0.8rem;
            color: #fff;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.3);
            color: #fff;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.5);
        }
        .btn-primary {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 0.8rem 2rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15,23,42,0.30);
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
        }
        .alert {
            border: none;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        .alert-success {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.1);
        }
        #map {
            height: 400px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }
        .location-button {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .location-button:hover {
            color: rgba(255,255,255,0.8);
            text-decoration: underline;
        }
        .location-error {
            color: #ff6b6b;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 5px;
            background-color: rgba(255,107,107,0.1);
        }
        .profile-image-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 1rem 0;
            border: 3px solid rgba(255,255,255,0.2);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .text-danger {
            color: #ff6b6b !important;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
@endsection

@section('main')
<div class="profile-container" style="direction: rtl;">
    <div class="profile-header">
        <h2>تعديل بيانات المتجر</h2>
    </div>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header">تحديث بيانات المتجر</div>
        <div class="card-body">
            <form action="{{ route('super.stores.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">الاسم</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $store->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $store->email) }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Phone -->
                <div class="form-group">
                    <label for="whatsapp" class="form-label">رقم الواتساب</label>
                    <input type="text" name="whatsapp" class="form-control" id="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}">
                    <small class="form-text text-muted">يرجى إدخال رقم الهاتف بصيغة دولية (مثال: +201234567890)</small>
                    @error('whatsapp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Image -->
                <div class="form-group">
                    <label for="image" class="form-label">الصورة</label>
                    @if ($store->image)
                        <img src="{{ asset($store->image) }}" alt="" class="profile-image-preview">
                    @endif
                    <input type="file" name="image" class="form-control" id="image">
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Category Selection -->
                <div class="form-group">
                    <label for="category_id" class="form-label">الفئة</label>
                    <select name="category_id" class="form-select" id="category_id">
                        <option value="">اختر فئة</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $store->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Delivery Time Min -->
                <div class="form-group">
                    <label for="delivery_time_min" class="form-label">أقل وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_min" class="form-control" id="delivery_time_min" value="{{ old('delivery_time_min', $store->delivery_time_min) }}">
                    @error('delivery_time_min')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Delivery Time Max -->
                <div class="form-group">
                    <label for="delivery_time_max" class="form-label">أقصى وقت للتوصيل (بالدقائق)</label>
                    <input type="number" name="delivery_time_max" class="form-control" id="delivery_time_max" value="{{ old('delivery_time_max', $store->delivery_time_max) }}">
                    @error('delivery_time_max')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Location Selection -->
                <div class="form-group">
                    <label class="form-label">الموقع</label>
                    <p>انقر على الخريطة لتحديد موقع المتجر أو <span class="location-button" id="use-device-location">استخدام موقع جهازك الحالي</span></p>
                    <div id="map"></div>
                    <div id="location-error" class="location-error" style="display: none;"></div>
                    <input type="hidden" name="lng" id="lng" value="{{ old('lng', $store->lng) }}">
                    <input type="hidden" name="lat" id="lat" value="{{ old('lat', $store->lat) }}">
                    @error('lng')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('lat')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">تحديث بيانات المتجر</button>
            </form>
        </div>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLocation = [31.2001, 29.9187]; // Fallback to Alexandria, Egypt
    const storeLat = {{ $store->lat ?? 'null' }};
    const storeLng = {{ $store->lng ?? 'null' }};
    const hasLocation = storeLat !== null && storeLng !== null;
    const storeLocation = hasLocation ? [storeLat, storeLng] : null;
    let map, marker;
    function initializeMap(center) {
        map = L.map('map').setView(center, 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);
        if (hasLocation) {
            marker = L.marker(storeLocation, { draggable: true }).addTo(map);
            marker.on('dragend', function(e) {
                updateLocation(marker.getLatLng());
            });
        }
        map.on('click', function(e) {
            if (!marker) {
                marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    updateLocation(marker.getLatLng());
                });
            } else {
                marker.setLatLng(e.latlng);
            }
            updateLocation(e.latlng);
        });
        map.on('tileerror', function() {
            document.getElementById('map').innerHTML = '<p class="text-danger">خطأ في تحميل الخريطة. يرجى التحقق من اتصال الإنترنت.</p>';
        });
    }
    function updateLocation(latlng) {
        document.getElementById('lat').value = latlng.lat;
        document.getElementById('lng').value = latlng.lng;
    }
    function requestDeviceLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const deviceLocation = [position.coords.latitude, position.coords.longitude];
                    map.setView(deviceLocation, 12);
                    if (marker) {
                        marker.setLatLng(deviceLocation);
                    } else {
                        marker = L.marker(deviceLocation, { draggable: true }).addTo(map);
                        marker.on('dragend', function(e) {
                            updateLocation(marker.getLatLng());
                        });
                    }
                    updateLocation({ lat: deviceLocation[0], lng: deviceLocation[1] });
                    document.getElementById('location-error').style.display = 'none';
                },
                function(error) {
                    let errorMessage = '';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'تم رفض الوصول إلى الموقع. يرجى السماح بالوصول في إعدادات المتصفح أو تحديد الموقع يدويًا.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'معلومات الموقع غير متوفرة. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'انتهت مهلة طلب الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                        default:
                            errorMessage = 'حدث خطأ أثناء جلب الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
                            break;
                    }
                    document.getElementById('location-error').innerText = errorMessage;
                    document.getElementById('location-error').style.display = 'block';
                },
                {
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        } else {
            document.getElementById('location-error').innerText = 'المتصفح لا يدعم تحديد الموقع. يرجى تحديد الموقع يدويًا على الخريطة.';
            document.getElementById('location-error').style.display = 'block';
        }
    }
    const center = storeLocation || defaultLocation;
    initializeMap(center);
    if (!hasLocation && navigator.permissions && navigator.permissions.query) {
        navigator.permissions.query({ name: 'geolocation' }).then(function(result) {
            if (result.state === 'granted') {
                requestDeviceLocation();
            } else if (result.state === 'prompt') {
                document.getElementById('location-error').innerText = 'لم يتم تحديد موقع المتجر. انقر على "استخدام موقع جهازك الحالي" للسماح بالوصول.';
                document.getElementById('location-error').style.display = 'block';
            } else if (result.state === 'denied') {
                document.getElementById('location-error').innerText = 'تم رفض الوصول إلى الموقع. يرجى السماح بالوصول في إعدادات المتصفح أو تحديد الموقع يدويًا.';
                document.getElementById('location-error').style.display = 'block';
            }
        }).catch(function() {
            document.getElementById('location-error').innerText = 'تعذر التحقق من إعدادات الموقع. يرجى تحديد الموقع يدويًا أو استخدام زر تحديد الموقع.';
            document.getElementById('location-error').style.display = 'block';
        });
    } else if (!hasLocation) {
        document.getElementById('location-error').innerText = 'لم يتم تحديد موقع المتجر. انقر على "استخدام موقع جهازك الحالي" للسماح بالوصول.';
        document.getElementById('location-error').style.display = 'block';
    }
    document.getElementById('use-device-location').addEventListener('click', function() {
        requestDeviceLocation();
    });
});
</script>
@endsection 