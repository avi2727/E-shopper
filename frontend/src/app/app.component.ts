import { Component, OnInit } from '@angular/core';
import { SharedCartService } from './shared-cart.service';
import { UserdataService } from './services/userdata.service';
import { AuthService } from './auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  cartData: any[] = [];
  cartItemCount: number = 0;

  constructor(private userdataService: UserdataService,
               private sharedCartService: SharedCartService, 
               private authService: AuthService
               ) {
                this.autoSignIn();
               }

  ngOnInit() {
    this.autoSignIn();  
    this.getcartdetails();
    this.authService.onLogin().subscribe(() => {
      this.getcartdetails();
    });
    this.authService.onLogout().subscribe(() => {
      this.getcartdetails();
    });
  }
  // getcartdetails() {
  //   const userDataString = sessionStorage.getItem('userData');
  //   const userId = userDataString ? JSON.parse(userDataString).userID : null;
  //   if (userId) {
  //     this.userdataService.getcartdetails(userId).subscribe((res: any) => {
  //       const cartData = res.cart_items || [];
    
  //       const cart_item_count = res.cart_item_count;
  //       cartData.forEach((item: any) => {
  //         item.total_price = item.price * item.quantity;
  //       });
  //       this.cartData = cartData;
  //       this.sharedCartService.setCartData(cartData);
  //       this.sharedCartService.setCartItemCount(cart_item_count);
  //     });
  //   } else {
  //     // Fetch data from session storage
  //     const sessionCartDataString = sessionStorage.getItem('sessionCartItem');
  //     const sessionCartData = sessionCartDataString ? JSON.parse(sessionCartDataString) : [];
  //     const cart_item_count = this.cartData.length + sessionCartData.length;
  //      // Calculate total cart item count
  //      this.sharedCartService.setCartItemCount(cart_item_count);
  //     const cartData = sessionCartData;
  //     cartData.forEach((item: any) => {
  //       item.total_price = item.price * item.quantity;
  //     });
  //     this.cartData = cartData;
  //     this.sharedCartService.setCartData(this.cartData);
  //   }
  // }
  getcartdetails() {
    const sessionCartDataString = sessionStorage.getItem('sessionCartItem');
    const sessionCartData = sessionCartDataString ? JSON.parse(sessionCartDataString) : [];
    
    const userDataString = sessionStorage.getItem('userData');
    const userId = userDataString ? JSON.parse(userDataString).userID : null;
    
    if (sessionCartData.length > 0) {
      // Display both session cart data and cart data from the database
      const cart_item_count = sessionCartData.length; // Set total item count for session cart data
      this.sharedCartService.setCartItemCount(cart_item_count);
  
      sessionCartData.forEach((item:any) => {
        item.total_price = item.price * item.quantity; // Calculate total price for session cart item
      });
  
      if (userId) {
        this.userdataService.getcartdetails(userId).subscribe((res: any) => {
          const cartDataFromDB = res.cart_items || [];
          const cart_item_count_db = res.cart_item_count;
  
          cartDataFromDB.forEach((item:any) => {
            item.total_price = item.price * item.quantity; // Calculate total price for cart item from DB
          });
  
          this.cartData = [...sessionCartData, ...cartDataFromDB]; // Merge both cart data arrays
          this.sharedCartService.setCartData(this.cartData);
          this.sharedCartService.setCartItemCount(cart_item_count + cart_item_count_db); // Total items count
  
          console.log('Both session cart data and database cart data displayed.');
        });
      } else {
        this.cartData = sessionCartData;
        this.sharedCartService.setCartData(this.cartData);
        console.log('Only session cart data displayed.');
      }
    } else if (userId) {
      // Display only cart data from the database
      this.userdataService.getcartdetails(userId).subscribe((res: any) => {
        const cartData = res.cart_items || [];
        const cart_item_count = res.cart_item_count;
  
        cartData.forEach((item:any) => {
          item.total_price = item.price * item.quantity; // Calculate total price for cart item from DB
        });
  
        this.cartData = cartData;
        this.sharedCartService.setCartData(cartData);
        this.sharedCartService.setCartItemCount(cart_item_count);
  
        console.log('Only database cart data displayed.');
      });
    } else {
      console.error('User data not found in local storage.');
    }
  }

  autoSignIn() {
    const userdata = sessionStorage.getItem('userData');
    if (userdata !== null) {
      const parsedUserData = JSON.parse(userdata);
      const userToken =parsedUserData.usertoken;
      this.userdataService.autoSignInWithToken(userToken).subscribe(
        (res: any) => {
          this.userdataService.setUserName(res.userName);
        },
        (error: any) => {
          console.error('Auto sign-in error:', error);
          sessionStorage.removeItem('userToken'); 
        }
      );
    // } else {
    //   console.log("User data or token not found");
    // }
  }
}
}
