@extends('layouts.admin')

@section('title', isset($product) ? 'Sửa sản phẩm' : 'Thêm sản phẩm')

@push('styles')
<style>
  .img-preview-wrap { position: relative; display: inline-block; }
  .img-preview { width: 120px; height: 120px; object-fit: contain;
    border: 2px solid #e8e4df; border-radius: 10px; background: #faf9f7; padding: 8px; }
  .img-preview-placeholder { width: 120px; height: 120px; border: 2px dashed #ddd;
    border-radius: 10px; display: flex; flex-direction: column;
    align-items: center; justify-content: center; color: #bbb; font-size: 12px; gap: 6px; }
  .img-preview-placeholder i { font-size: 28px; }
</style>
@endpush

@section('content')

{{-- ══ PAGE HEADER ══ --}}
<div class="page-header">
  <div class="page-header-left">
    <a href="{{ route('admin.products.index') }}" class="back-link">
      <i class="fa-solid fa-arrow-left"></i> Quay lại
    </a>
    <h1 class="page-title">
      <i class="fa-solid fa-{{ isset($product) ? 'pen' : 'plus' }}"></i>
      {{ isset($product) ? 'Sửa: ' . $product->name : 'Thêm sản phẩm mới' }}
    </h1>
  </div>
</div>

{{-- ══ FORM ══ --}}
<form method="POST"
      action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data"
      id="productForm">
  @csrf
  @if(isset($product)) @method('PUT') @endif

  <div class="form-layout">

    {{-- ════ CỘT TRÁI: Thông tin chính ════ --}}
    <div class="form-main">

      {{-- Tên sản phẩm --}}
      <div class="form-card">
        <div class="form-card-title">Thông tin cơ bản</div>

        <div class="form-group">
          <label>Tên sản phẩm <span class="required">*</span></label>
          <input type="text" name="name" class="form-input @error('name') is-error @enderror"
                 value="{{ old('name', $product->name ?? '') }}"
                 placeholder="VD: ASUS ROG Strix G16 RTX 4070" required />
          @error('name')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-row-2">
          <div class="form-group">
            <label>Danh mục <span class="required">*</span></label>
            <select name="category" class="form-input @error('category') is-error @enderror" required>
              <option value="">-- Chọn danh mục --</option>
              @foreach(['Laptop Gaming','Laptop Văn phòng','PC Gaming','Điện thoại','Máy tính bảng','Màn hình','Phụ kiện','Bàn phím','Chuột gaming','Tai nghe'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $product->category ?? '') == $cat ? 'selected' : '' }}>
                  {{ $cat }}
                </option>
              @endforeach
            </select>
            @error('category')<span class="form-error">{{ $message }}</span>@enderror
          </div>

          <div class="form-group">
            <label>Nhãn hiển thị (badge)</label>
            <select name="badge" class="form-input">
              <option value="">-- Không có --</option>
              @foreach(['Hot','Mới','Bán chạy','Mới về','Sale'] as $b)
                <option value="{{ $b }}" {{ old('badge', $product->badge ?? '') == $b ? 'selected' : '' }}>
                  {{ $b }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Mô tả ngắn</label>
          <textarea name="description" class="form-input form-textarea" rows="4"
                    placeholder="Mô tả tóm tắt sản phẩm...">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
      </div>

      {{-- Giá --}}
      <div class="form-card">
        <div class="form-card-title">Giá bán</div>
        <div class="form-row-2">
          <div class="form-group">
            <label>Giá bán <span class="required">*</span></label>
            <div class="input-suffix">
              <input type="number" name="price" class="form-input @error('price') is-error @enderror"
                     value="{{ old('price', $product->price ?? '') }}"
                     placeholder="33490000" min="0" required />
              <span>₫</span>
            </div>
            @error('price')<span class="form-error">{{ $message }}</span>@enderror
          </div>
          <div class="form-group">
            <label>Giá gốc (để gạch ngang)</label>
            <div class="input-suffix">
              <input type="number" name="price_old" class="form-input"
                     value="{{ old('price_old', $product->price_old ?? '') }}"
                     placeholder="38000000" min="0" />
              <span>₫</span>
            </div>
          </div>
        </div>
        {{-- Preview giảm giá --}}
        <div class="discount-preview" id="discountPreview" style="display:none">
          <i class="fa-solid fa-tag"></i>
          Giảm <strong id="discountPct"></strong> — Tiết kiệm <strong id="discountAmt"></strong>₫
        </div>
      </div>

      {{-- Thông số kỹ thuật --}}
      <div class="form-card">
        <div class="form-card-title">
          Thông số kỹ thuật
          <button type="button" class="btn-add-spec" id="addSpec">
            <i class="fa-solid fa-plus"></i> Thêm dòng
          </button>
        </div>
        <div id="specsWrap">
          @php $specs = old('specs', isset($product) ? $product->specs : []); @endphp
          @if($specs)
            @foreach($specs as $key => $val)
            <div class="spec-row">
              <input type="text" name="specs_key[]" class="form-input" value="{{ $key }}" placeholder="VD: CPU" />
              <input type="text" name="specs_val[]" class="form-input" value="{{ $val }}" placeholder="VD: Intel Core i9-14900HX" />
              <button type="button" class="btn-remove-spec"><i class="fa-solid fa-minus"></i></button>
            </div>
            @endforeach
          @else
            <div class="spec-row">
              <input type="text" name="specs_key[]" class="form-input" placeholder="VD: CPU" />
              <input type="text" name="specs_val[]" class="form-input" placeholder="VD: Intel Core i9" />
              <button type="button" class="btn-remove-spec"><i class="fa-solid fa-minus"></i></button>
            </div>
          @endif
        </div>
      </div>

    </div>

    {{-- ════ CỘT PHẢI: Ảnh + Cài đặt ════ --}}
    <div class="form-side">

      {{-- Ảnh chính --}}
      <div class="form-card">
        <div class="form-card-title">Ảnh chính</div>
        <div class="upload-zone" id="mainUploadZone">
          <input type="file" name="image" id="mainImage" accept="image/*" hidden />
          <div class="upload-preview" id="mainPreview">
            @if(isset($product) && $product->image)
              <img src="{{ asset('storage/' . $product->image) }}" class="img-preview" id="mainImgPreview" />
            @else
              <div class="img-preview-placeholder" id="mainPlaceholder">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Click để chọn ảnh</span>
                <span style="font-size:11px;color:#ccc">JPG, PNG, WEBP — tối đa 2MB</span>
              </div>
            @endif
          </div>
          <button type="button" class="btn-upload" onclick="document.getElementById('mainImage').click()">
            <i class="fa-solid fa-image"></i>
            {{ isset($product) && $product->image ? 'Đổi ảnh' : 'Chọn ảnh' }}
          </button>
        </div>
      </div>

      {{-- Ảnh gallery --}}
      <div class="form-card">
        <div class="form-card-title">Ảnh gallery (nhiều ảnh)</div>
        <div class="gallery-upload-zone">
          <input type="file" name="images[]" id="galleryImages" accept="image/*" multiple hidden />
          <div class="gallery-previews" id="galleryPreviews">
            @if(isset($product) && $product->images)
              @foreach($product->images as $img)
                <div class="gallery-thumb">
                  <img src="{{ asset('storage/' . $img) }}" />
                </div>
              @endforeach
            @endif
          </div>
          <button type="button" class="btn-upload btn-upload-sm"
                  onclick="document.getElementById('galleryImages').click()">
            <i class="fa-solid fa-images"></i> Thêm ảnh gallery
          </button>
        </div>
      </div>

      {{-- Kho + Cài đặt --}}
      <div class="form-card">
        <div class="form-card-title">Kho hàng &amp; Cài đặt</div>

        <div class="form-group">
          <label>Số lượng tồn kho <span class="required">*</span></label>
          <input type="number" name="stock" class="form-input @error('stock') is-error @enderror"
                 value="{{ old('stock', $product->stock ?? 0) }}" min="0" required />
          @error('stock')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="toggle-group">
          <label class="toggle-item">
            <div>
              <div class="toggle-label">Hiển thị trên web</div>
              <div class="toggle-desc">Sản phẩm sẽ xuất hiện trên cửa hàng</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" name="is_active" value="1"
                     {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }} />
              <span class="toggle-slider"></span>
            </label>
          </label>

          <label class="toggle-item">
            <div>
              <div class="toggle-label">Sản phẩm nổi bật</div>
              <div class="toggle-desc">Hiển thị ở mục "Sản phẩm nổi bật"</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" name="is_featured" value="1"
                     {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} />
              <span class="toggle-slider"></span>
            </label>
          </label>

          <label class="toggle-item">
            <div>
              <div class="toggle-label">Flash Sale ⚡</div>
              <div class="toggle-desc">Hiển thị ở mục Flash Sale</div>
            </div>
            <label class="toggle-switch">
              <input type="checkbox" name="is_flash_sale" value="1"
                     {{ old('is_flash_sale', $product->is_flash_sale ?? false) ? 'checked' : '' }} />
              <span class="toggle-slider"></span>
            </label>
          </label>
        </div>

        {{-- Flash sale settings --}}
        <div class="flash-settings" id="flashSettings"
             style="{{ old('is_flash_sale', $product->is_flash_sale ?? false) ? '' : 'display:none' }}">
          <div class="form-row-2">
            <div class="form-group">
              <label>Đã bán</label>
              <input type="number" name="flash_sale_sold" class="form-input"
                     value="{{ old('flash_sale_sold', $product->flash_sale_sold ?? 0) }}" min="0" />
            </div>
            <div class="form-group">
              <label>Tổng số</label>
              <input type="number" name="flash_sale_total" class="form-input"
                     value="{{ old('flash_sale_total', $product->flash_sale_total ?? 100) }}" min="1" />
            </div>
          </div>
        </div>
      </div>

      {{-- Submit --}}
      <div class="form-actions">
        <button type="submit" class="btn-save">
          <i class="fa-solid fa-floppy-disk"></i>
          {{ isset($product) ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn-cancel">Huỷ</a>
      </div>

    </div>
  </div>

</form>
@endsection

@push('scripts')
<script>
// ── Preview ảnh chính ──
document.getElementById('mainImage').addEventListener('change', function () {
  const file = this.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    let img = document.getElementById('mainImgPreview');
    const placeholder = document.getElementById('mainPlaceholder');
    if (placeholder) placeholder.remove();
    if (!img) {
      img = document.createElement('img');
      img.id = 'mainImgPreview';
      img.className = 'img-preview';
      document.getElementById('mainPreview').prepend(img);
    }
    img.src = e.target.result;
  };
  reader.readAsDataURL(file);
});

// ── Preview ảnh gallery ──
document.getElementById('galleryImages').addEventListener('change', function () {
  const wrap = document.getElementById('galleryPreviews');
  Array.from(this.files).forEach(file => {
    const reader = new FileReader();
    reader.onload = e => {
      const div = document.createElement('div');
      div.className = 'gallery-thumb';
      div.innerHTML = `<img src="${e.target.result}" />`;
      wrap.appendChild(div);
    };
    reader.readAsDataURL(file);
  });
});

// ── Thêm / xoá dòng thông số ──
document.getElementById('addSpec').addEventListener('click', function () {
  const row = document.createElement('div');
  row.className = 'spec-row';
  row.innerHTML = `
    <input type="text" name="specs_key[]" class="form-input" placeholder="VD: RAM" />
    <input type="text" name="specs_val[]" class="form-input" placeholder="VD: 32GB DDR5" />
    <button type="button" class="btn-remove-spec"><i class="fa-solid fa-minus"></i></button>
  `;
  document.getElementById('specsWrap').appendChild(row);
  row.querySelector('.btn-remove-spec').addEventListener('click', () => row.remove());
});

document.querySelectorAll('.btn-remove-spec').forEach(btn => {
  btn.addEventListener('click', function () {
    this.closest('.spec-row').remove();
  });
});

// ── Flash sale toggle ──
document.querySelector('[name="is_flash_sale"]').addEventListener('change', function () {
  document.getElementById('flashSettings').style.display = this.checked ? 'block' : 'none';
});

// ── Tính % giảm giá live ──
function calcDiscount() {
  const price    = parseFloat(document.querySelector('[name="price"]').value)   || 0;
  const priceOld = parseFloat(document.querySelector('[name="price_old"]').value) || 0;
  const preview  = document.getElementById('discountPreview');
  if (priceOld > price && price > 0) {
    const pct = Math.round((1 - price / priceOld) * 100);
    const amt = (priceOld - price).toLocaleString('vi-VN');
    document.getElementById('discountPct').textContent = `-${pct}%`;
    document.getElementById('discountAmt').textContent = amt;
    preview.style.display = 'flex';
  } else {
    preview.style.display = 'none';
  }
}
document.querySelector('[name="price"]').addEventListener('input', calcDiscount);
document.querySelector('[name="price_old"]').addEventListener('input', calcDiscount);
calcDiscount();
</script>
@endpush