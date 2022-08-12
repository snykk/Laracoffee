<!-- Product Detail Modal -->
<div class="program-modal modal fade" id="ProductDetailModal" tabindex="-1" role="dialog" aria-hidden="true"
  data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="close-modal" data-bs-dismiss="modal"><img src="{{ asset('storage/icons/close-icon.svg') }}"
                  alt="Close Modal" />
            </div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="modal-body">
                            <!-- Product details-->
                            <h2 class="text-uppercase">
                            </h2>
                            <br>
                            <p class="orientasi text-center">
                                <!-- Orientation -->
                            </p>
                            <img id="modal-image" width="70%" class="img-fluid d-block mx-auto" alt="" />
                            <div>
                                <h3>
                                    Description
                                </h3>
                                <div class="content">
                                    <div>
                                        <p class="description">
                                            <!-- Description -->
                                        </p>
                                    </div>
                                    <div class="pembagi"></div>
                                    <div class="price">
                                        <!-- Price -->
                                    </div>
                                    <div class="stock">
                                        <!-- content stok -->
                                    </div>
                                    <div class="discount">
                                        <!-- content stok -->
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-xl j mt-4" data-bs-dismiss="modal" type="button"> Back to
                                Product List</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Detail Modal -->