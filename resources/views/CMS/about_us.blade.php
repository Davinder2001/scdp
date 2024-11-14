@extends('layout.master')

{{-- @if (auth()->user()->role_id != '1')
    <script type="text/javascript">
        window.location = "/dashboard";
    </script>
@endif --}}

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">About Us</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Master</a></li>
                        <li class="breadcrumb-item active">About Us</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif
            @if (session()->has('update'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-success">
                        {{ session()->get('update') }}
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                </div>
            @endif
            @if (session()->has('delete'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
                    <div class="alert alert-danger">
                        {{ session()->get('delete') }}
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 float-sm-right">
                    <div class="card">
                        @if (auth()->user()->role_id != '1')
                        {{-- If user role id = 2 --}}
                        <div class="card-header">
                            {{-- <h3>About Us Recoards</h3> --}}
                        </div>

                        @else
						<div class="card-header">
							<div class="row">
							<div class="col-md-6">
							<div class="box-uploader">
                                <form action="{{ route('cms-about-us-import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file" id="customFile">
                                    <button type="submit" class="btn btn-info btn-md">Import PDF</button>
                                </form>
							</div>
							</div>
							{{-- <div class="col-md-6">
                           <button type="submit" class="btn btn-dark btn-right" onclick="window.location='{{ url('create-soe-budget-allocation') }}'">Add Soe budget allocation </button>
                        </div> --}}
						</div>
						</div>
                        @endif

                        <div class="card-body table-responsive" style="overflow-x:auto;">
                            @if (isset($latestPdf))
                            {{-- <h2>Latest PDF</h2> --}}
                            <iframe src="{{ Storage::url($latestPdf->file_path) }}" width="100%" height="600px"></iframe>
                        @else
                        <p>No Records Found</p>
                        @endif
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('.show-alert-delete-box').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                title: "Are you sure you want to delete this record?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                buttons: ["Cancel", "Yes!"],
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });

        function DoubleScroll(element) {
            var scrollbar = document.createElement('div');
            scrollbar.appendChild(document.createElement('div'));
            scrollbar.style.overflow = 'auto';
            scrollbar.style.overflowY = 'hidden';
            scrollbar.firstChild.style.width = element.scrollWidth + 'px';
            scrollbar.firstChild.style.paddingTop = '1px';
            scrollbar.firstChild.appendChild(document.createTextNode('\xA0'));
            scrollbar.onscroll = function() {
                element.scrollLeft = scrollbar.scrollLeft;
            };
            element.onscroll = function() {
                scrollbar.scrollLeft = element.scrollLeft;
            };
            element.parentNode.insertBefore(scrollbar, element);
        }

        DoubleScroll(document.getElementById('doublescroll'));
    </script>

    <style>
        #doublescroll {
            overflow: auto;
            overflow-y: hidden;
        }

        #doublescroll p {
            margin: 0;
            padding: 1em;
            white-space: nowrap;
        }
    </style>
@endsection
