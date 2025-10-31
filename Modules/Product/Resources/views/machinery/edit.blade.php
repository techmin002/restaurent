@extends('setting::layouts.master')

@section('title', 'Edit Accessory')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Accessory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('products-accessories.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Accessory</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="product-form" action="{{ route('products-machineries.update',$machinery->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter Name " value="{{ $machinery->name }}" required>
                                                @error('name')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" class="form-control"
                                                       placeholder="Enter Price" value="{{ $machinery->sales_price }}" required>
                                                @error('price')
                                                <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="brand">Brand</label>
                                                <select name="brand_id" id="" class="form-control" required>
                                                    <option value="" selected disabled>Select Brand</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            {{ $brand->id == $machinery->brand_id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('brand_id')
                                                <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select name="category_id" id="" class="form-control" required>
                                                    <option value="" selected disabled>Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == $machinery->category_id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea type="text" name="description" class="summernote" placeholder="Enter Description">{{ $machinery->description }}</textarea>
                                                @error('description')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="features">Features</label>
                                                <textarea type="text" name="feature" class="summernote" placeholder="Enter features">{{ $machinery->feature }}</textarea>
                                                @error('features')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Cover Image </label>

                                                <input type="file" id="file-ip-1" accept="image/*"
                                                    class="form-control-file border" value="{{ $machinery->image }}"
                                                    onchange="showPreview1(event);" name="image">
                                                @error('image')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div class="preview mt-2">
                                                    <img src="" id="file-ip-1-preview" width="200px">
                                                </div>
                                                <div>
                                                    <img src="{{ asset('upload/images/machinery/'.$machinery->image) }}"  width="200px">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Images <small>(Optional)</small> </label>

                                                <input type="file" accept="image/*" multiple
                                                    class="form-control-file border" value="{{ $machinery->images }}" name="images[]">
                                                @error('images')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                                <div>
                                                    @php
                                                        $images = json_decode($machinery->images, true);
                                                    @endphp
                                                    @foreach($images as $image)
                                                    <img src="{{ asset('upload/images/machineries/'.$image) }}" width="100px" style="border:1px solid black"alt="">
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Units</label>
                                                <select name="units" class="form-control" id="">
                                                    <option value="" selected disabled>Select Unit</option>
                                                    <option value="qty">Quantity</option>
                                                    <option value="ltr"@if($machinery['units'] == 'ltr')selected @endif>Liter</option>
                                                    <option value="kg" @if($machinery['units'] == 'kg')selected @endif>Kilogram</option>
                                                    <option value="meter" @if($machinery['units'] == 'meter')selected @endif>Meter</option>
                                                    <option value="inch" @if($machinery['units'] == 'inch')selected @endif>Inch</option>
                                                    <option value="other" @if($machinery['units'] == 'other')selected @endif>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Bootstrap Switch -->
                                            <div class="card card-secondary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Publish</h3>
                                                </div>
                                                <div class="card-body">
                                                    @if($machinery->status == 'on')
                                                        <input type="checkbox" name="status" checked data-bootstrap-switch
                                                            data-off-color="danger" data-on-color="success" >
                                                    @else
                                                        <input type="checkbox" name="status" data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <script type="text/javascript">
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>

@endsection
