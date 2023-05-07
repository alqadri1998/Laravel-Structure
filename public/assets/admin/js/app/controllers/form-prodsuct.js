/**
 * Created by Malik on 5/11/2020.
 */
app.controller('productFormController', [
    '$scope', '$common', '$window',
    function ($scope, $common, $window) {
        // $scope.result = null;
        $scope.productId = productId;
        $scope.formData = {
            id: 0,
            titleEn: '',
            titleAr: '',
            category: '',
            subcategory: '',
            subsubcategory: '',
            attributes: [],
            subAttributes: [],
            is_book: 0,
            author_name: '',
            isbn: '',
            price: '',
            vat: 0,
            quantity: '',
            offer: 0,
            discount: '',
            discount_percent: '',
            descriptionEn: '',
            descriptionAr: '',
            image: '',
            images: [],
            imagesDependent: false,
            brand: '',
            origin: '',
            year: '',
            sku: '',
            promotion: '',
        };
        $scope.categories = [];
        $scope.brands =[];
        $scope.origins =[];
        $scope.years =[];
        $scope.promotions =[];
        $scope.subcategories = [];
        $scope.subsubcategories = [];
        $scope.attributes = [];
        $scope.propertiesIds = [];
        $scope.properties = [];
        // $scope.properties = [{
        //     id: 1,
        //     title: 'Attribute 1',
        //     imagesDependent: false,
        //     priceDependent: false,
        //     quantityDependent: false,
        //     sub_attributes: [
        //         {
        //             id: 2, title: 'Property 1', images: [{path: '', isDefault: false}], quantity: 0, price: 0
        //         }
        //     ]
        // }];
        $scope.working = false
        $scope.errors = [];
        $scope.required = true;

        $scope.categoriesFunction = function () {
            $common.categories().then(function (response) {
                // console.log(response);
                if (response.data.success) {
                    console.log('this is categories response data =>',response.data.data.collection);
                    $scope.categories = response.data.data.collection;
                    console.log('after assigning scope.categories =>', $scope.categories);
                    if($scope.productId > 0){
                        setTimeout(() => {
                            console.log('edit product function is initiated');
                            $scope.editProduct()
                        }, 300)
                    }
                    // console.log($scope.categories);
                } else {
                    $scope.result = response;
                }
            }, function (response) {
                $scope.result = response;
            });
        };

        $scope.brandsFunction = function () {
            $common.brands().then(function (response) {
                // console.log('this is response from brands',response);
                if (response.data.success) {
                    $scope.brands = response.data.data.collection;
                    // console.log('this is scope brands',$scope.brands);
                } else {
                    $scope.result = response;
                }
            }, function (response) {
                $scope.result = response;
            });
        };

        $scope.yearsFunction = function (){
            var current_year = new Date().getFullYear();
            for(var i = current_year - 20; i <= current_year; i++){
                $scope.years.push(i);
            }
            // console.log('This is the current year',current_year);
            // console.log('These are all years',$scope.years);
        }

        $scope.originsFunction = function () {
            $common.origin().then(function (response) {
                // console.log('this is response from origins',response);
                if (response.data.success) {
                    $scope.origins = response.data.data.collection;
                    // console.log('this is scope origins',$scope.origins);

                } else {
                    $scope.result = response;
                }
            }, function (response) {
                $scope.result = response;
            });
        };

        $scope.promotionsFunction = function () {
            $common.promotions().then(function (response) {
                // console.log('this is response from promotion',response);
                if (response.data.success) {
                    $scope.promotions = response.data.data.collection;
                    // console.log('this is scope origins',$scope.origins);

                } else {
                    $scope.result = response;
                }
            }, function (response) {
                $scope.result = response;
            });
        };

        $scope.selectedCategory = function () {
            console.log('in selected category function');
            $scope.subcategories = [];
            $scope.subsubcategories = [];
            $scope.formData.subcategory = '';
            $scope.formData.subsubcategory = '';
            $scope.properties = [];
            console.log('this is scope.categories=>', $scope.categories);
            for(let category of $scope.categories){
                console.log('its checking categories and saving attributes');
                if(category.id == $scope.formData.category){
                    console.log('this is category.id and formdata category =>',category.id,$scope.formData.category);
                    console.log('this is category =>', category);
                    $scope.subcategories = category.subCategories;
                    $scope.attributes = category.attributes
                }
            }
        };



        $scope.selectedSubCategory = function () {
            $scope.subsubcategories = [];
            $scope.formData.subsubcategory = '';
            for(let category of $scope.subcategories){
                // console.log($scope.formData.subcategory)
                if(category.id == $scope.formData.subcategory){
                    $scope.subsubcategories = category.subCategories;
                }
            }
        };

        $scope.selectedAttributes = function () {
            console.log('this is scope.attributes =>',$scope.attributes)
            for(let attribute of $scope.attributes){
                let att = attribute.id.toString()
                if($scope.formData.attributes.indexOf(att) > -1 && $scope.propertiesIds.indexOf(att) == -1){
                    $scope.properties.push({
                        id: attribute.id,
                        title: attribute.translation.name,
                        subAttributes: attribute.subAttributes,
                        imagesDependent: false,
                        priceDependent: false,
                        quantityDependent: false,
                        sub_attributes:[],
                        sub_attributes_ids: [],
                        selectSubAttributes:''
                    });
                    $scope.propertiesIds.push(att)
                    // console.log($scope.properties);
                }else if($scope.formData.attributes.indexOf(att) == -1 && $scope.propertiesIds.indexOf(att) > -1){
                    $scope.properties.splice($scope.propertiesIds.indexOf(att), 1),
                        $scope.propertiesIds.splice($scope.propertiesIds.indexOf(att), 1)
                }
            }
        };

        $scope.selectedSubAttributes = function (attributeIndex) {
            // console.log("before =>", $scope.properties[attributeIndex]);
            for(let subattribute of $scope.properties[attributeIndex].subAttributes){
               if($scope.properties[attributeIndex].selectSubAttributes.indexOf(subattribute.id.toString()) > -1 && $scope.properties[attributeIndex].sub_attributes_ids.indexOf(subattribute.id) == -1){
                   $scope.properties[attributeIndex].sub_attributes.push({
                       id: subattribute.id,
                       title: subattribute.translation.name,
                       images: [],
                       quantity: 0,
                       price: 0
                   });
                   $scope.properties[attributeIndex].sub_attributes_ids.push(subattribute.id)
               }else if($scope.properties[attributeIndex].selectSubAttributes.indexOf(subattribute.id.toString()) == -1 && $scope.properties[attributeIndex].sub_attributes_ids.indexOf(subattribute.id) > -1){
                   $scope.properties[attributeIndex].sub_attributes_ids.splice($scope.properties[attributeIndex].sub_attributes_ids.indexOf(subattribute.id), 1)
                   for(let subAttributeIndex in $scope.properties[attributeIndex].sub_attributes){
                        if($scope.properties[attributeIndex].sub_attributes[subAttributeIndex].id == subattribute.id){
                            $scope.properties[attributeIndex].sub_attributes.splice(subAttributeIndex, 1)
                            break;
                        }
                   }
                  
               }
            }
            // console.log("After =>", $scope.properties[attributeIndex]);
        };

        $scope.attributesDependentImages = function (attributeIndex) {
            // console.log("before =>", $scope.properties[attributeIndex]);
            if($scope.properties[attributeIndex].imagesDependent == true){
                $scope.formData.imagesDependent = false;
                $scope.properties[attributeIndex].imagesDependent = false
                $scope.formData.images = [];
                $scope.formData.image = '';
                for(let subAttribute of $scope.properties[attributeIndex].sub_attributes){
                    subAttribute.images = [];
                }
            }else{
                for(let property of $scope.properties){
                    property.imagesDependent = false
                }
                $scope.formData.imagesDependent = true;
                $scope.properties[attributeIndex].imagesDependent = true;
            }
            // for(let property of $scope.properties){
            //     property.imagesDependent = false
            // }
            // $scope.formData.imagesDependent = true;
            // $scope.properties[attributeIndex].imagesDependent = true;
            // console.log("After =>", $scope.properties[attributeIndex]);
        };

        $scope.isBook = function () {
            // console.log($scope.formData.is_book)
            if($scope.formData.is_book == 1){
                $scope.formData.is_book = 0
            }else{
                $scope.formData.is_book = 1
            }
        };
        
        $scope.isOffer = function () {
            
            if($scope.formData.offer == 1){
                $scope.formData.offer = 0
            }else{
                $scope.formData.offer = 1
            }
            // console.log($scope.formData.offer)
        };

        $scope.includingVat = function () {
            // console.log($scope.formData.vat)
            if($scope.formData.vat == 1){
                $scope.formData.vat = 0
            }else{
                $scope.formData.vat = 1
            }
        };
        
        $scope.editProduct = function () {
            // console.log($scope.productId)
            $common.editProduct({'product_id': $scope.productId}).then(function (response) {
                if (response.data.success) {
                    let product = response.data.data.collection.product
                    // console.log("Subcategory =>", product.subcategory > 0);
                    $scope.formData = {
                        id: product.id,
                        titleEn: product.titleEn,
                        titleAr: product.titleAr,
                        category: '',
                        // subcategory: product.subcategory.toString(),
                        // subsubcategory: subsubcategory,
                        is_book: product.is_book,
                        author_name: product.author_name,
                        isbn: product.isbn,
                        price: product.price,
                        vat: product.vat,
                        quantity: product.quantity,
                        offer: product.offer,
                        discount: product.discount,
                        discount_percent: product.discount_percent,
                        descriptionEn: product.descriptionEn,
                        descriptionAr: product.descriptionAr,
                        image: product.image,
                        images: [],
                        imagesDependent: (product.images_dependent == 1) ? true : false,
                        attributes: [],
                        subAttributes: [],
                        brand:'',
                        origin:'',
                        promotion:'',
                        year:product.year,
                        sku:product.sku,
                    };
                    if(product.images.length > 0){
                        for(let image of product.images){
                            $scope.formData.images.push({
                                image: image.image,
                                path: image.image,
                                isDefault: (image.default_image == 1) ? true: false
                            })
                        }
                    }
                    for(let attribute of product.attributes){
                        if(attribute.parent_id == 0){
                            $scope.formData.attributes.push(attribute.id.toString())
                        }
                    }
                    $scope.formData.category = (product.category > 0) ? product.category.toString() : '';
                    console.log('selected category function is going to run');
                    $scope.selectedCategory();
                    console.log('selected category function is has run');
                    console.log('selected subcategory function start');
                    $scope.selectedSubCategory();   
                    console.log('selected subcategory function complete'); 
                    console.log('selected attribute function start'); 
                    $scope.selectedAttributes();
                    console.log('selected attribute function complete'); 
                    for(let pAttribute of product.attributes){
                        if(pAttribute.parent_id != 0){
                            for(let property of $scope.properties){
                                for(let subAttribute of property.subAttributes){
                                    if(pAttribute.id == subAttribute.id){
                                        property.imagesDependent = (pAttribute.pivot.images_dependent == 1) ? true : false
                                        property.sub_attributes.push({
                                            id: subAttribute.id,
                                            title: subAttribute.translation.name,
                                            images: (pAttribute.pivot.images == null) ? [] : JSON.parse(pAttribute.pivot.images),
                                            quantity: 0,
                                            price: 0
                                        });
                                        property.sub_attributes_ids.push(subAttribute.id);
                                        property.selectSubAttributes = subAttribute.id.toString();
                                    }
                                }
                            }
                        }
                    }
                    $scope.formData.brand = (product.brand_id > 0) ? product.brand_id.toString() : '';
                    $scope.formData.origin = (product.origin_id > 0) ? product.origin_id.toString() : '';
                    $scope.formData.promotion = (product.promotion_id > 0) ? product.promotion_id.toString() : '';
                    $scope.formData.subcategory = (product.subcategory > 0) ? product.subcategory.toString() : '';
                    $scope.formData.subsubcategory = (product.subsubcategory > 0) ? product.subsubcategory.toString() : '';
                    // console.log('This is formData',$scope.formData);
                    // console.log('these are properties',$scope.properties);
                    console.log('this is formDate=>',$scope.formData);
                    console.log('these are attributes =>', $scope.attributes)
                } else {
                    toastr.error(response.message, 'Error');
                }
            }, function (response) {
                toastr.error(response, 'Error');
            });
        };

        $scope.submitProduct = function (isValid) {
            // console.log(isValid)
            if($scope.working == true){
                return;
            }
            if (isValid) {
                $scope.working = true
                $scope.formData.mainAttributes = [];
                let images = [];
                for (let attribute of $scope.properties) {
                    $scope.formData.mainAttributes.push({
                        attribute_id: attribute.id,
                        parent_attribute_id: 0,
                        imagesDependent: attribute.imagesDependent
                    });
                    for (let property of attribute.sub_attributes) {
                        $scope.formData.mainAttributes.push({
                            attribute_id: property.id,
                            parent_attribute_id: attribute.id,
                            images: property.images,
                            imagesDependent: attribute.imagesDependent
                        });
                        images.push(...property.images)
                    }
                }
                if ($scope.formData.imagesDependent == true) {
                    for (let image of images) {
                        if (image.isDefault == true) {
                            $scope.formData.image = image.image;
                            break;
                        }
                    }
                    $scope.formData.images = images
                }
                if ($scope.formData.discount == null) {
                    $scope.formData.discount = 0
                }
                if ($scope.formData.discount_percent == null) {
                    $scope.formData.discount_percent = 0
                }

                // console.log($scope.formData);
                $common.saveProduct($scope.formData).then(function (response) {
                    // console.log(response);
                    if (response.data.success) {
                        toastr.success(response.data.message, 'Success');
                        window.location.href = $window.Laravel.baseUrl + "products";
                        // $scope.working = false
                    } else {
                        $scope.working = false
                        toastr.error(response.message, 'Error');
                    }
                }, function (response) {
                    $scope.working = false
                    $scope.removeErrors()
                    // console.log(response.data.errors)
                    angular.forEach(response.data.errors, function (value, key) {
                        $scope.errors.push(value[0])
                    })
                    // console.log($scope.errors);
                    // toastr.error(response, 'Error');
                });
            }
                                                                       
        };

        $scope.imageUploadButton = function (aIndex = -1, sAIndex = -1) {
            if(aIndex == -1){
                $('#upload_image_input').click();
            }else{
                $(`#upload_image_input-${aIndex}-${sAIndex}`).click();
            }
        }

        $scope.uploadImage = function (files, elem = -1) {
            // console.log(elem);
            $(".fa-spinner").show();
            $('.product-upload-image').attr('disabled', true);
            var formData = new FormData();
            formData.append("image", files[0]);
            var url = window.Laravel.baseUrl + 'upload-image';
            $.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    }
                })
                .done( (res) => {
                    // $('.public_select_image').val(res.data);
                   if(elem == -1){
                       let image = window.Laravel.base+res.data;
                       let data = {
                           image: res.data,
                           path: image,
                           isDefault: false
                       };
                       if($scope.formData.images.length == 0){
                           data = {
                               image: res.data,
                               path: image,
                               isDefault: true
                           };
                           $scope.formData.image = res.data;
                       }
                       $scope.$apply(function () {
                           $scope.formData.images.push(data);
                       });

                   }else{
                       let aIndex = elem.getAttribute("data-attributeIndex");
                       let sAIndex = elem.getAttribute("data-sunattributeIndex");
                       // console.log(sAIndex);
                       let image = window.Laravel.base+res.data;
                       let data = {
                           image: res.data,
                           path: image,
                           isDefault: false
                       };
                       if($scope.properties[aIndex].sub_attributes[sAIndex].images.length == 0){
                           data = {
                               image: res.data,
                               path: image,
                               isDefault: true
                           };
                       }
                       $scope.$apply(function () {
                           $scope.properties[aIndex].sub_attributes[sAIndex].images.push(data);
                       });

                       $scope.formData.images.push({
                           image: res.data,
                           isDefault: data.isDefault
                       });
                   }
                    $(".fa-spinner").hide();
                    $('.product-upload-image').removeAttr('disabled');
                    toastr.success(res.message, 'Success');
                })
                // .fail(function (res) {
                //     alert('Something went wrong, please try later.');
                // });
        };

        $scope.makeDefault = function (index, aIndex=-1, sAIndex = -1) {
            // console.log(aIndex, sAIndex);
            if(aIndex == -1){
                for(let imageIndex in $scope.formData.images){
                    $scope.formData.images[imageIndex].isDefault = false
                }
                $scope.formData.images[index].isDefault = true
                $scope.formData.image = $scope.formData.images[index].image;
            }else{
                // console.log($scope.properties[aIndex]);
                for(let imageIndex in  $scope.properties[aIndex].sub_attributes[sAIndex].images){
                    $scope.properties[aIndex].sub_attributes[sAIndex].images[imageIndex].isDefault = false;
                }
                $scope.properties[aIndex].sub_attributes[sAIndex].images[index].isDefault = true
            }
        }

        $scope.deleteImage = function(index, aIndex=-1, sAIndex = -1) {
            if(aIndex == -1) {
                $scope.formData.images.splice(index, 1);
            }else{
                $scope.properties[aIndex].sub_attributes[sAIndex].images.splice(index, 1)
            }
        }

        $scope.removeErrors = function () {
            $scope.errors = [];
        }



        $scope.init = function () {
            console.log('system initiated');
            $scope.categoriesFunction();
            $scope.brandsFunction();
            $scope.originsFunction();
            $scope.promotionsFunction();
            $scope.yearsFunction();
          
        };
        $scope.init();
    }
]);