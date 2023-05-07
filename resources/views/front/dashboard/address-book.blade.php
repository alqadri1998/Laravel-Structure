@extends('front.layouts.app')
@section('content')
     @include('front.common.breadcrumb')
               <!-- pormotions html start -->
               <section class="custom-sec-inner-account address-book-edit ">
                    <div class="dashborad-ses">
                         <div class="container">
                              <div class="row">
                                   @include('front.dashboard.common.left-navbar')
                                   <div class="col-md-12 col-lg-9">
                                        <div class="row">
                                             <div class="col-md-12">
                                                  <h2 class="my-account-tittle">Default Addresses</h2>
                                             </div>
                                             <div class="col-md-6">
                                                  <div class="main-my-account-pagee">
                                                       <h3 class="info-tittle">Default Billing Address</h3>
                                                       <div class="inner-my-account">
                                                           @if(isset($billingAddress))
                                                            <p class="p-innr-acc">
                                                                {{$billingAddress->first_name}}
                                                            </p>
                                                            <p class="p-innr-acc">
                                                                {{$billingAddress->last_name}}
                                                            </p>
                                                            <p class="p-innr-acc">
                                                                {{$billingAddress->address}}

                                                            </p>
                                                               <p class="p-innr-acc">
                                                                   {{$billingAddress->city}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$billingAddress->country}}
                                                               </p>
                                                            <p class="p-innr-acc">
                                                                {{$billingAddress->post_code}}
                                                            </p>
                                                            <p class="p-innr-acc">
                                                                 T: {{$billingAddress->user_phone}}
                                                            </p>
                                                           @endif
                                                       </div>
                                                      @if(isset($billingAddress))
                                                       <div class="my-ccount-edit">
                                                           <a href="{{route('front.dashboard.address.edit', $billingAddress->id)}}" class="edit-btn-my">Change Default Billing Address</a>
                                                       </div>
                                                      @else
                                                      <div class="my-ccount-edit">
                                                          <button type="button" class="edit-btn-my">No address selected as billing address</button>
                                                      </div>
                                                      @endif
                                                  </div>
                                             </div>
                                             <div class="col-md-6">
                                                  <div class="main-my-account-pagee">
                                                       <h3 class="info-tittle">Default Shipping Address</h3>
                                                       <div class="inner-my-account">
                                                           @if(isset($shippingAddress))
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->first_name}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->last_name}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->address}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->city}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->country}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   {{$shippingAddress->post_code}}
                                                               </p>
                                                               <p class="p-innr-acc">
                                                                   T: {{$shippingAddress->user_phone}}
                                                               </p>
                                                           @endif
                                                       </div>
                                                      @if(isset($shippingAddress))
                                                       <div class="my-ccount-edit">
                                                           <a href="{{route('front.dashboard.address.edit', $shippingAddress->id)}}" class="edit-btn-my">Change Default Shipping Address</a>
                                                       </div>
                                                      @else
                                                          <div class="my-ccount-edit">
                                                              <button type="button" class="edit-btn-my">No Address Selected as Shipping Address</button>
                                                          </div>
                                                      @endif
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-12">
                                                  <h2 class="my-account-tittle mt-5">Additional Address Entries </h2>
                                             </div>
                                            @forelse($addresses as $address)
                                             <div class="col-md-6">
                                                  <div class="main-my-account-pagee mb-5">
                                                       <h3 class="info-tittle">Extra Address</h3>
                                                       <div class="inner-my-account">
                                                           <p class="p-innr-acc">
                                                               {{$address->first_name}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               {{$address->last_name}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               {{$address->address}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               {{$address->city}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               {{$address->country}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               {{$address->post_code}}
                                                           </p>
                                                           <p class="p-innr-acc">
                                                               T: {{$address->user_phone}}
                                                           </p>
                                                       </div>
                                                       <div class="my-ccount-edit">
                                                           <a href="{{route('front.dashboard.address.edit', $address->id)}}" class="edit-btn-my">Edit Address</a>
                                                           <a href="{{route('front.dashboard.address.destroy', $address->id)}}" class="edit-btn-my-2">Delete Address</a>
                                                       </div>
                                                  </div>
                                             </div>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div class="additional-address-box">
                                             <div class="additional-entries-row border-tb">
                                                  <div class="address-btn d-flex justify-content-end">
                                                       <a href="{{route('front.dashboard.address.edit', 0)}}" class="btn btn--primary btn--animate">add new address</a>
                                                  </div>
                                                  <h2 class="my-account-tittle mt-5">Additional Address Entries </h2>                                                  
                                             </div>
                                             <div class="table-responsive address-table">
                                                  <table class="table">
                                                       <thead>
                                                         <tr class="border-b d-flex justifiy-content-between">
                                                           <th class="title f-name">First Name</th>
                                                           <th class="title l-name">Last Name</th>
                                                           <th class="title address">Address</th>
                                                           <th class="title city">City</th>
                                                             <th class="title country">Country </th>
                                                             <th class="title zip">Zip/Postal <br> Code</th>
                                                           <th class="title phone">Phone</th>
                                                         </tr>
                                                       </thead>
                                                       <tbody>
                                                       @forelse($addresses as $address)
                                                         <tr class="border-b d-flex justifiy-content-between subtitle-row">
                                                             <td class="sub-title f-name">{{$address->first_name}}</td>
                                                             <td class="sub-title l-name"> {{$address->last_name}}</td>
                                                             <td class="sub-title address">{{$address->address}}</td>
                                                             <td class="sub-title city">{{$address->city}}</td>
                                                             <td class="sub-title country">{{$address->country}}</td>
                                                             <td class="sub-title zip">{{$address->post_code}}</td>
                                                             <td class="sub-title phone">
                                                                 <div class="subtitle-box d-flex">
                                                                     {{$address->user_phone}}
                                                                     <div class="icons-block">
                                                                         <a href="{{route('front.dashboard.address.edit', $address->id)}}"
                                                                            class="edit-btn-my">
                                                                             <i class="fas fa-edit"></i></a>
                                                                         <a href="{{route('front.dashboard.address.destroy', $address->id)}}"><i
                                                                                     class="fas fa-trash-alt border-r"></i></a>
                                                                     </div>
                                                                 </div>
                                                             </td>
                                                         </tr>
                                                       @empty
                                                       @endforelse
                                                       </tbody>
                                                     </table>
                                             </div>
                                        </div>                                        
                                   </div>
                              </div>                              
                         </div>
                    </div>

               </section>
               <!-- end pormotion html -->
@endsection
