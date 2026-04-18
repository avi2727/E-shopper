import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { UserdataService } from '../services/userdata.service';
import { SharedCartService } from '../shared-cart.service';

@Component({
  selector: 'app-product-detail',
  templateUrl: './product-detail.component.html',
  styleUrls: ['./product-detail.component.css']
})
export class ProductDetailComponent implements OnInit {

  productId: string | null | undefined;
  productData: any; // Make sure the response matches this structure
  quantity: number = 1;
  target: string = '';
  userId: any;
  sessionCartItems: any[] = [];
  cartItemCount: number = 0;
  constructor(private route: ActivatedRoute, 
    private userdataService: UserdataService, 
    private router: Router,
    private sharedCartService: SharedCartService,
    ) { }

  ngOnInit() {
    this.route.paramMap.subscribe(params => {
      this.productId = params.get('id');
      this.product_detail(this.productId);
    });
    const sessionCartString = sessionStorage.getItem('sessionCartItem');
    if (sessionCartString) {
      this.sessionCartItems = JSON.parse(sessionCartString);
    }
  }

  product_detail(id: any) {
    this.userdataService.getproductdetails(id).subscribe((res: any) => {
      this.productData = res;
    });
  }

  increaseQuantity() {
    this.quantity++;
  }

  decreaseQuantity() {
    if (this.quantity > 1) {
      this.quantity--;
    }
  }

  addToCart() {
    const userDataString = sessionStorage.getItem('userData');
    let userId = null;

    if (userDataString) {
      const userData = JSON.parse(userDataString);
      userId = userData.userID;
    }

    const cartItem = {
      quantity: this.quantity,
      productId: this.productId, // Assuming 'id' is the correct property
      userId: userId
    };

    if (userId) {
      if (this.productData) {
        this.addCartItemToBackend(cartItem);
      }else{
        console.log("Product data is not available yet");
      }
    } else {
      if (this.productData) {
        this.addCartItemToSessionStorage(cartItem);
      }else{
        console.log("Product data is not available yet");
      }
   
    }
  }

  addCartItemToBackend(cartItem: any) {
    this.userdataService.addtocart(cartItem).subscribe((res: any) => {
      if (res.code == 1) {
        this.handleCartAdditionSuccess(res.message);
      } else if (res.code == 2) {
        this.handleCartAdditionError(res.message);
      }
    });
  }

  addCartItemToSessionStorage(cartItem: any) {
    if(this.productData){
      this.productData[0].quantity=cartItem.quantity;
        let cartdata= [];
        // sessionStorage.setItem('sessionCartItem', JSON.stringify(this.sessionCartItems));
        let localCartData=sessionStorage.getItem('sessionCartItem');
        if(!localCartData){
          sessionStorage.setItem('sessionCartItem', JSON.stringify(this.productData));
        }else{
          cartdata=JSON.parse(localCartData);
          cartdata.push(this.productData[0]);
          sessionStorage.setItem('sessionCartItem', JSON.stringify(cartdata));
          const sessionCartDataString = sessionStorage.getItem('sessionCartItem');
      if (sessionCartDataString !== null) {
        const sessionCartData = JSON.parse(sessionCartDataString);
        this.cartItemCount = sessionCartData.length; // Calculate the updated cart item count
        this.sharedCartService.setCartItemCount(this.cartItemCount);
      }

          this.target = '<div class="alert alert-info"> Cart item stored in session!' + '</div>';
          setTimeout(() => {
               this.router.navigate(['/cart']);
                this.target = '';
               }, 2000);
        }
       
     }
  }
  handleCartAdditionSuccess(message: string) {
    this.target = '<div class="alert alert-success"> Success!' + message + '</div>';
    setTimeout(() => {
      this.router.navigate(['/cart']);
    }, 1000);
  }

  handleCartAdditionError(message: string) {
    this.target = '<div class="alert alert-danger"> Error!' + message + '</div>';
    setTimeout(() => {
      this.target = '';
    }, 2000);
  }
}
