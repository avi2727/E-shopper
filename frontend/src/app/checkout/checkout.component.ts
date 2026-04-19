import { Component, OnInit } from '@angular/core';
import {  Router } from '@angular/router';
import { SharedCartService } from '../shared-cart.service';
import { UserdataService } from '../services/userdata.service';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.css']
})
export class CheckoutComponent implements OnInit {
  target:string = '';
  cartData: any[] = [];
  cartItemCount: number = 0;
  name: string = '';
  email: string = '';
  contact: string = '';
  address1: string = '';
  address2: string = '';
  country: string = '';
  city: string = '';
  state: string = '';
  zip: string = '';
  product_id:string='';
  product_name:string='';
  product_price:string='';
  product_subtotal:string='';
  payment:string='';
  userid:string='';
  product_quantity:string='';
  constructor( private router: Router,private sharedCartService: SharedCartService,private userdataService: UserdataService) { }

ngOnInit() {
  const userDataString = sessionStorage.getItem('userData');
  if (userDataString) {
    const userData = JSON.parse(userDataString);
    const userId = userData.userID;
    this.name = userData.userName;
    this.email = userData.userEmail;
    this.userid= userData.userID;
    this.userdataService.getCartDetails(userId).subscribe((res: any) => {
      const cartData = res.cart_items || [];
      const cart_item_count = res.cart_item_count;
      cartData.forEach((item: any) => {
        item.total_price = item.price * item.quantity; // Calculate total price for cart item from DB
      });

      this.cartData = cartData;
    });
  } else {
    console.error('User data not found in session storage.');
  }
}

  calculateSubtotal(): number {
    return this.cartData.reduce((subtotal: any, item: { total_price: any; }) => subtotal + item.total_price, 0);
  }

  calculateTotal(): number {
    return this.calculateSubtotal() + 10; // Add shipping cost
  }

  onSubmitcheckoutForm() {
    // Validate required fields
    if (!this.name || !this.email || !this.contact || !this.address1 || !this.city || !this.state || !this.zip || !this.payment) {
      this.target = '<div class="alert alert-danger">Please fill in all required fields marked with * and select a payment method.</div>';
      setTimeout(() => { this.target = ''; }, 3000);
      return;
    }

    // Calculate the sum of all product_subtotal values
    let totalProductSubtotals = 0;
    this.cartData.forEach(product => {
      totalProductSubtotals += product.total_price;
    });
  
    const formData = {
      name: this.name,
      email: this.email,
      contact: this.contact,
      address1: this.address1,
      address2: this.address2,
      country: this.country,
      city: this.city,
      state: this.state,
      zip: this.zip,
      product_id: this.cartData.map(product => product.product_id).join(', '),
      product_name: this.cartData.map(product => product.name).join(', '),
      product_price: this.cartData.map(product => product.price).join(', '),
      product_quantity: this.cartData.map(product => product.quantity).join(', '),
      product_subtotal: totalProductSubtotals, // Sum of all product_subtotal values
      payment: this.payment,
      userid: this.userid
    };
    this.userdataService.checkout(formData).subscribe((res:any)=>{ 
     // console.log(res);
      if(res.code==1){
        this.target ='<div class="alert alert-success"> Success!'+res.message+'</div>';
        this.router.navigate(['/order']);
      }else if(res.code==2){
        this.target ='<div class="alert alert-danger"> Error!'+res.message+'</div>';
      }
      setTimeout(() => {
        this.target = '';
      }, 2000);
    });
    //console.log(formData);
  }
  
  
}
