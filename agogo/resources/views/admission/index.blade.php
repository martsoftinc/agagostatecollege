@extends('layout')

@section('title', 'Admission Application — Agogo State College')

@section('content')
<!-- ============ ADMISSION HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> 2026/2027 Academic Year
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Admission application
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Complete the form below to apply for Form 1. Places are limited across all six programmes.
    </p>
  </div>
</section>

<!-- ============ APPLICATION FORM ============ -->
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16">

  @if ($errors->any())
    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
      <p class="font-semibold mb-2">Please fix the following errors:</p>
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form
    action="{{route('admission.store')}}"
    method="POST"
    enctype="multipart/form-data"
    class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-8"
  >
    @csrf

    <!-- 1. Passport photo -->
    <div>
      <h2 class="font-bold text-lg text-ink flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-lime/30 text-forest flex items-center justify-center text-sm font-extrabold">1</span>
        Passport picture
      </h2>
      <p class="mt-1 text-sm text-muted">Upload a recent passport-size photo (JPEG or PNG, max 2MB).</p>
      <div class="mt-4 flex flex-col sm:flex-row items-start gap-5">
        <div id="passportPreview" class="w-32 h-40 rounded-2xl border-2 border-dashed border-gray-200 bg-ivory flex items-center justify-center overflow-hidden shrink-0">
          <span class="text-muted text-xs text-center px-2" id="passportPlaceholder">No photo<br>selected</span>
          <img id="passportImg" src="" alt="Passport preview" class="w-full h-full object-cover hidden">
        </div>
        <div class="flex-1 w-full">
          <label for="passport_picture" class="block text-sm font-semibold text-ink mb-2">Passport picture <span class="text-red-500">*</span></label>
          <input
            type="file"
            name="passport_picture"
            id="passport_picture"
            accept="image/jpeg,image/png,image/jpg"
            required
            class="block w-full text-sm text-muted file:mr-4 file:py-2.5 file:px-5 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-lime file:text-forest-deep hover:file:bg-lime-soft file:cursor-pointer cursor-pointer"
          >
          @error('passport_picture')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
          @enderror
          <p class="mt-2 text-xs text-muted">Clear face, plain background preferred.</p>
        </div>
      </div>
    </div>

    <div class="dashed-line"></div>

    <!-- 2. Student details -->
    <div>
      <h2 class="font-bold text-lg text-ink flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-lime/30 text-forest flex items-center justify-center text-sm font-extrabold">2</span>
        Student details
      </h2>
      <div class="mt-5 grid sm:grid-cols-2 gap-4 sm:gap-5">
        <div>
          <label for="surname" class="block text-sm font-semibold text-ink mb-1.5">Surname <span class="text-red-500">*</span></label>
          <input type="text" name="surname" id="surname" required value="{{ old('surname') }}" placeholder="Family name"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('surname')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="first_name" class="block text-sm font-semibold text-ink mb-1.5">First name <span class="text-red-500">*</span></label>
          <input type="text" name="first_name" id="first_name" required value="{{ old('first_name') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('first_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
          <label for="middle_name" class="block text-sm font-semibold text-ink mb-1.5">Middle name <span class="text-muted font-normal">(optional)</span></label>
          <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('middle_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="gender" class="block text-sm font-semibold text-ink mb-1.5">Gender <span class="text-red-500">*</span></label>
          <select name="gender" id="gender" required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition bg-white">
            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
          </select>
          @error('gender')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="date_of_birth" class="block text-sm font-semibold text-ink mb-1.5">Date of birth <span class="text-red-500">*</span></label>
          <input type="date" name="date_of_birth" id="date_of_birth" required value="{{ old('date_of_birth') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('date_of_birth')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="place_of_birth" class="block text-sm font-semibold text-ink mb-1.5">Place of birth</label>
          <input type="text" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}" placeholder="Town / city"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('place_of_birth')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="nationality" class="block text-sm font-semibold text-ink mb-1.5">Nationality <span class="text-red-500">*</span></label>
          <input type="text" name="nationality" id="nationality" required value="{{ old('nationality', 'Ghanaian') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('nationality')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="religion" class="block text-sm font-semibold text-ink mb-1.5">Religion</label>
          <input type="text" name="religion" id="religion" value="{{ old('religion') }}" placeholder="Optional"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('religion')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
          <label for="home_town" class="block text-sm font-semibold text-ink mb-1.5">Home town / region</label>
          <input type="text" name="home_town" id="home_town" value="{{ old('home_town') }}" placeholder="e.g. Agogo, Ashanti"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('home_town')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    <div class="dashed-line"></div>

    <!-- 3. Academic background -->
    <div>
      <h2 class="font-bold text-lg text-ink flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-lime/30 text-forest flex items-center justify-center text-sm font-extrabold">3</span>
        Academic background
      </h2>
      <div class="mt-5 grid sm:grid-cols-2 gap-4 sm:gap-5">
        <div class="sm:col-span-2">
          <label for="previous_school" class="block text-sm font-semibold text-ink mb-1.5">Previous / junior high school <span class="text-red-500">*</span></label>
          <input type="text" name="previous_school" id="previous_school" required value="{{ old('previous_school') }}" placeholder="Name of JHS"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('previous_school')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="index_number" class="block text-sm font-semibold text-ink mb-1.5">BECE index number <span class="text-red-500">*</span></label>
          <input type="text" name="index_number" id="index_number" required value="{{ old('index_number') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('index_number')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="bece_year" class="block text-sm font-semibold text-ink mb-1.5">BECE year</label>
          <input type="text" name="bece_year" id="bece_year" value="{{ old('bece_year') }}" placeholder="e.g. 2026"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('bece_year')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
          <label for="programme" class="block text-sm font-semibold text-ink mb-1.5">Preferred programme <span class="text-red-500">*</span></label>
          <select name="programme" id="programme" required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition bg-white">
            <option value="" disabled {{ old('programme') ? '' : 'selected' }}>Select programme</option>
            <option value="general_science" {{ old('programme') === 'general_science' ? 'selected' : '' }}>General Science</option>
            <option value="business" {{ old('programme') === 'business' ? 'selected' : '' }}>Business</option>
            <option value="general_arts" {{ old('programme') === 'general_arts' ? 'selected' : '' }}>General Arts</option>
            <option value="visual_arts" {{ old('programme') === 'visual_arts' ? 'selected' : '' }}>Visual Arts</option>
            <option value="home_economics" {{ old('programme') === 'home_economics' ? 'selected' : '' }}>Home Economics</option>
            <option value="agricultural_science" {{ old('programme') === 'agricultural_science' ? 'selected' : '' }}>Agricultural Science</option>
          </select>
          @error('programme')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
          <label for="position_held" class="block text-sm font-semibold text-ink mb-1.5">Position held <span class="text-muted font-normal">(optional)</span></label>
          <input type="text" name="position_held" id="position_held" value="{{ old('position_held') }}" placeholder="e.g. Prefectorial, class captain, club president"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('position_held')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    <div class="dashed-line"></div>

    <!-- 4. Interests & health -->
    <div>
      <h2 class="font-bold text-lg text-ink flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-lime/30 text-forest flex items-center justify-center text-sm font-extrabold">4</span>
        Interests &amp; health
      </h2>
      <div class="mt-5 grid sm:grid-cols-1 gap-4 sm:gap-5">
        <div>
          <label for="interests_hobbies" class="block text-sm font-semibold text-ink mb-1.5">Interests / hobbies</label>
          <textarea name="interests_hobbies" id="interests_hobbies" rows="3" placeholder="e.g. football, reading, music, debate, science club"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition resize-y">{{ old('interests_hobbies') }}</textarea>
          @error('interests_hobbies')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="medical_conditions" class="block text-sm font-semibold text-ink mb-1.5">Medical conditions</label>
          <textarea name="medical_conditions" id="medical_conditions" rows="3" placeholder="List any allergies, chronic conditions, or special medical needs. Write None if not applicable."
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition resize-y">{{ old('medical_conditions') }}</textarea>
          @error('medical_conditions')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
          <p class="mt-1.5 text-xs text-muted">This information is kept confidential and helps us support your child on campus.</p>
        </div>
      </div>
    </div>

    <div class="dashed-line"></div>

    <!-- 5. Parent / guardian -->
    <div>
      <h2 class="font-bold text-lg text-ink flex items-center gap-2">
        <span class="w-8 h-8 rounded-lg bg-lime/30 text-forest flex items-center justify-center text-sm font-extrabold">5</span>
        Parent / guardian
      </h2>
      <div class="mt-5 grid sm:grid-cols-2 gap-4 sm:gap-5">
        <div class="sm:col-span-2">
          <label for="parent_guardian_name" class="block text-sm font-semibold text-ink mb-1.5">Full name <span class="text-red-500">*</span></label>
          <input type="text" name="parent_guardian_name" id="parent_guardian_name" required value="{{ old('parent_guardian_name') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('parent_guardian_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="parent_guardian_phone" class="block text-sm font-semibold text-ink mb-1.5">Phone number <span class="text-red-500">*</span></label>
          <input type="tel" name="parent_guardian_phone" id="parent_guardian_phone" required value="{{ old('parent_guardian_phone') }}" placeholder="+233 ..."
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('parent_guardian_phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="parent_guardian_email" class="block text-sm font-semibold text-ink mb-1.5">Email</label>
          <input type="email" name="parent_guardian_email" id="parent_guardian_email" value="{{ old('parent_guardian_email') }}" placeholder="Optional"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('parent_guardian_email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="relationship" class="block text-sm font-semibold text-ink mb-1.5">Relationship to student <span class="text-red-500">*</span></label>
          <select name="relationship" id="relationship" required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition bg-white">
            <option value="" disabled {{ old('relationship') ? '' : 'selected' }}>Select</option>
            <option value="father" {{ old('relationship') === 'father' ? 'selected' : '' }}>Father</option>
            <option value="mother" {{ old('relationship') === 'mother' ? 'selected' : '' }}>Mother</option>
            <option value="guardian" {{ old('relationship') === 'guardian' ? 'selected' : '' }}>Guardian</option>
            <option value="other" {{ old('relationship') === 'other' ? 'selected' : '' }}>Other</option>
          </select>
          @error('relationship')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="parent_guardian_occupation" class="block text-sm font-semibold text-ink mb-1.5">Occupation <span class="text-red-500">*</span></label>
          <input type="text" name="parent_guardian_occupation" id="parent_guardian_occupation" required value="{{ old('parent_guardian_occupation') }}"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('parent_guardian_occupation')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="place_of_residence" class="block text-sm font-semibold text-ink mb-1.5">Place of residence <span class="text-red-500">*</span></label>
          <input type="text" name="place_of_residence" id="place_of_residence" required value="{{ old('place_of_residence') }}" placeholder="Town / city"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition">
          @error('place_of_residence')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
          <label for="address" class="block text-sm font-semibold text-ink mb-1.5">Residential address <span class="text-red-500">*</span></label>
          <textarea name="address" id="address" rows="3" required placeholder="House number, street, town, region"
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition resize-y">{{ old('address') }}</textarea>
          @error('address')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>
      </div>
    </div>

    <div class="dashed-line"></div>

    <!-- Declaration -->
    <div>
      <label class="flex items-start gap-3 cursor-pointer">
        <input type="checkbox" name="declaration" value="1" required class="mt-1 w-4 h-4 rounded border-gray-300 text-forest focus:ring-forest" {{ old('declaration') ? 'checked' : '' }}>
        <span class="text-sm text-muted leading-relaxed">
          I confirm that the information provided is true and complete. I understand that false information may lead to withdrawal of an offer of admission.
        </span>
      </label>
      @error('declaration')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="pt-2">
      <button type="submit"
        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-8 py-3.5 rounded-full hover:bg-lime-soft transition-colors text-sm sm:text-base shadow-sm">
        Submit application <i data-lucide="send" class="w-4 h-4"></i>
      </button>
      <p class="mt-3 text-xs text-muted">
        Application fee: <strong class="text-ink">GHS 30.00</strong>. You will be redirected to complete payment after submitting.
      </p>
      <p class="mt-1 text-xs text-muted">
        Need help? Call <a href="tel:+233244000000" class="text-forest font-medium hover:underline">+233 24 400 0000</a>
        or email <a href="mailto:info@agogostatecollege.edu.gh" class="text-forest font-medium hover:underline">info@agogostatecollege.edu.gh</a>
      </p>
    </div>
  </form>
</section>
@endsection

@push('scripts')
<script>
  const input = document.getElementById('passport_picture');
  const img = document.getElementById('passportImg');
  const placeholder = document.getElementById('passportPlaceholder');

  if (input) {
    input.addEventListener('change', function () {
      const file = this.files && this.files[0];
      if (!file) {
        img.classList.add('hidden');
        img.src = '';
        placeholder.classList.remove('hidden');
        return;
      }
      const reader = new FileReader();
      reader.onload = function (e) {
        img.src = e.target.result;
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
      };
      reader.readAsDataURL(file);
    });
  }
</script>
@endpush
