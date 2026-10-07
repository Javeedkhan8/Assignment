@extends('layouts.market')

@section('title', 'Post Your Ad - '.config('app.name'))

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <nav class="text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-1">/</span>
            <span class="text-gray-700">Post an Ad</span>
        </nav>

        <h1 class="mt-3 text-2xl font-bold text-gray-900">Post Your Ad</h1>
        <p class="mt-1 text-sm text-gray-500">Fill in the details below. Your ad will appear on the site immediately after submission.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('listings.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm space-y-5" id="ad-form">
            @csrf

            <fieldset>
                <legend class="text-sm font-medium text-gray-700">Ad type <span class="text-red-500">*</span></legend>
                <div class="mt-2 flex gap-4">
                    <label class="flex items-center gap-2 rounded-md border border-gray-300 px-4 py-2 text-sm cursor-pointer has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="type" value="product" class="text-indigo-600 focus:ring-indigo-500" @checked(old('type', 'product') === 'product')>
                        Product
                    </label>
                    <label class="flex items-center gap-2 rounded-md border border-gray-300 px-4 py-2 text-sm cursor-pointer has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                        <input type="radio" name="type" value="service" class="text-indigo-600 focus:ring-indigo-500" @checked(old('type') === 'service')>
                        Service
                    </label>
                </div>
            </fieldset>

            <div>
                <label class="block text-sm font-medium text-gray-700">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required maxlength="120"
                       placeholder="e.g. Used Honda City 2019 or Home Deep Cleaning Service"
                       class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Detail <span class="text-red-500">*</span></label>
                <textarea name="detail" rows="5" required maxlength="5000" placeholder="Describe your product or service..."
                          class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('detail') }}</textarea>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id) data-slug="{{ $category->slug }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select subcategory</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country <span class="text-red-500">*</span></label>
                    <select name="country_id" id="country_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @selected((string) old('country_id') === (string) $country->id)>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">State <span class="text-red-500">*</span></label>
                    <select name="state_id" id="state_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select state</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">City <span class="text-red-500">*</span></label>
                    <select name="city_id" id="city_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select city</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Area</label>
                    <select name="area_id" id="area_id"
                            class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select area</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (&#8377;) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="0.01"
                           class="mt-1 block w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Image (optional, max 2 MB)</label>
                    <input type="file" name="image" accept="image/*" id="image-input"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100">
                </div>
            </div>

            <div id="image-preview" class="hidden">
                <img id="preview-img" src="" alt="Preview" class="h-40 w-40 rounded-lg object-cover border border-gray-200">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Submit Ad
                </button>
                <a href="{{ route('listings.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-800">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        const json = async (url) => {
            const res = await fetch(url);
            if (!res.ok) throw new Error('Request failed');
            return res.json();
        };

        const fill = (select, items, placeholder, selected = null) => {
            select.innerHTML = `<option value="">${placeholder}</option>` +
                items.map(item => `<option value="${item.id}" ${String(selected) === String(item.id) ? 'selected' : ''}>${item.name}</option>`).join('');
        };

        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const countrySelect = document.getElementById('country_id');
        const stateSelect = document.getElementById('state_id');
        const citySelect = document.getElementById('city_id');
        const areaSelect = document.getElementById('area_id');

        categorySelect.addEventListener('change', async () => {
            subcategorySelect.disabled = true;
            if (!categorySelect.value) return fill(subcategorySelect, [], 'Select subcategory');
            const items = await json(`/api/subcategories?category_id=${categorySelect.value}`);
            fill(subcategorySelect, items, 'Select subcategory', @json(old('subcategory_id')));
            subcategorySelect.disabled = false;
        });

        countrySelect.addEventListener('change', async () => {
            fill(stateSelect, [], 'Select state');
            fill(citySelect, [], 'Select city');
            fill(areaSelect, [], 'Select area');
            if (!countrySelect.value) return;
            const states = await json(`/api/states?country_id=${countrySelect.value}`);
            fill(stateSelect, states, 'Select state', @json(old('state_id')));
        });

        stateSelect.addEventListener('change', async () => {
            fill(citySelect, [], 'Select city');
            fill(areaSelect, [], 'Select area');
            if (!stateSelect.value) return;
            const cities = await json(`/api/cities?state_id=${stateSelect.value}`);
            fill(citySelect, cities, 'Select city', @json(old('city_id')));
        });

        citySelect.addEventListener('change', async () => {
            fill(areaSelect, [], 'Select area');
            if (!citySelect.value) return;
            const areas = await json(`/api/areas?city_id=${citySelect.value}`);
            fill(areaSelect, areas, 'Select area', @json(old('area_id')));
        });

        document.getElementById('image-input').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            if (!file) { preview.classList.add('hidden'); return; }
            document.getElementById('preview-img').src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        });

        // initialise cascading values after validation errors
        (async () => {
            if (countrySelect.value) {
                await countrySelect.dispatchEvent(new Event('change'));
                if (stateSelect.value) {
                    await stateSelect.dispatchEvent(new Event('change'));
                }
            }
            if (categorySelect.value) {
                await categorySelect.dispatchEvent(new Event('change'));
            }
        })();
    </script>
@endsection
