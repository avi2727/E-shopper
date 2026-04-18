import { Component } from '@angular/core';
import { UserdataService } from '../services/userdata.service';
import { Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { SharedCartService } from '../shared-cart.service';
@Component({
  selector: 'app-shopping-cart',
  templateUrl: './shopping-cart.component.html',
  styleUrls: ['./shopping-cart.component.css']
})
export class ShoppingCartComponent {
  cartData: any[] = [];
  cartItemCount: any;
  constructor(
    private userdataService: UserdataService,
    private router: Router,
    private sharedCartService: SharedCartService,
    private _snackBar: MatSnackBar,
  ) { }
  ngOnInit() {
    this.getcartdetails();
  }
  

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
        });
      } else {
        this.cartData = sessionCartData;
        this.sharedCartService.setCartData(this.cartData);
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
      });
    } else {
      console.log('User data not found in local storage.');
    }
  }
  
  
  updateTotal(item: any) {
    item.total_price = item.price * item.quantity;
    const userDataString = sessionStorage.getItem('userData');
    const userId = userDataString ? JSON.parse(userDataString).userID : null;
    if (userId) {
    this.updatedata(item);
    }
  }
  increaseQuantity(item: any) {
    item.quantity++;
    
    this.updateTotal(item);
  }
  decreaseQuantity(item: any) {
    if (item.quantity > 1) {
      item.quantity--;
      this.updateTotal(item);
    }
  }
  updatedata(item: any) {
    this.userdataService.updateCartItem(item).subscribe((res: any) => {
      console.log("Item updated successfully:", res);
    }, error => {
      console.error("Error updating item:", error);
    });
  }
  calculateTotalPrice(): number {
    let totalPrice = 0;
    for (const item of this.cartData) {
      totalPrice += item.price * item.quantity;
    }
    return totalPrice;
  }

  proceedToCheckout() {
    const userDataString = sessionStorage.getItem('userData');
    if (userDataString) {
      const userData = JSON.parse(userDataString);
      const userId = userData.userID;
      const previousCartDataString = sessionStorage.getItem('sessionCartItem');
      if (previousCartDataString) {
        const previousCartData = JSON.parse(previousCartDataString);
        const cartDataForBackend = previousCartData.map((item:any) => {
          return {
            product_id: item.id,
            quantity: item.quantity,
            cart_id: item.cart_id
          };
        });
        this.userdataService.insertCartData(userId, cartDataForBackend).subscribe(
          (response) => {
            console.log('Previous cart data inserted:', response);
            sessionStorage.removeItem('sessionCartItem');
            this.router.navigate(['/checkout']);
          },
          (error) => {
            console.error('Error inserting previous cart data:', error);
          }
        );
      } else {
        console.log('No previous cart data found.');
        this.router.navigate(['/checkout']);
      }
    } else {
      console.error('User data not found in local storage.');
      this.openSnackBar('Please login to Checkout!', '');
    }
  }
  
  removeCartItem(cart_id: any, user_id: any, index: number) {
    if (user_id && cart_id) {
        // User is logged in, perform removal using service
        this.userdataService.removeCartItem(cart_id, user_id).subscribe((response) => {
          this.getcartdetails();
        });
    } else if (index >= 0) {
        // User is not logged in, remove from sessionStorage using index
        
        // Get the sessionCartData from sessionStorage
        const sessionCartDataString = sessionStorage.getItem('sessionCartItem');
        const sessionCartData = sessionCartDataString ? JSON.parse(sessionCartDataString) : [];

        // Check if the index is within the valid range for sessionCartData
        if (index >= 0 && index < sessionCartData.length) {
            // Remove the item from sessionCartData using the index
            sessionCartData.splice(index, 1);
            this.getcartdetails();
            // Update the sessionStorage with the modified sessionCartData
            sessionStorage.setItem('sessionCartItem', JSON.stringify(sessionCartData));
            // Optionally, update any other logic or data related to sessionCartData
        } else {
            alert("Invalid index for sessionStorage");
        }
        
        // Remove the item from the cartData array
        this.cartData.splice(index, 1);
        this.sharedCartService.setCartData(this.cartData);
    } else {
        alert("Invalid parameters provided");
    }
}



  openSnackBar(message: string, action: string) {
    this._snackBar.open(message, action, {
      verticalPosition: 'top',
      horizontalPosition: 'center',
    
      duration:2000,
      
    });
  }
}
