import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { UserdataService } from './services/userdata.service';

@Injectable({
  providedIn: 'root'
})
export class SharedCartService {
  private cartData: any[] = [];
  private cartItemCountSubject: BehaviorSubject<number> = new BehaviorSubject<number>(0);

  constructor(private userdataService: UserdataService) {}

  // fetchCartData(userId: any) {
  //   alert(userId);
  //   this.userdataService.getcartdetails(userId).subscribe((res: any) => {
  //     const cartData = res.cart_items || [];
  //     const cart_item_count = res.cart_item_count;
  //     cartData.forEach((item: any) => {
  //       item.total_price = item.price * item.quantity; // Calculate total price for cart item from DB
  //     });
  //     this.cartData = cartData;
  //     this.setCartItemCount(cart_item_count);
  //   });
  // }

  setCartData(data: any[]) {
    this.cartData = data;
    console.log("sharedservice setCartdata", data);
  }

  // getCartData() {
  //   console.log("sharedservice getCartdata", this.cartData);
  //   return this.cartData;
  // }

  setCartItemCount(count: number) {
    this.cartItemCountSubject.next(count);
  }

  getCartItemCount() {
    return this.cartItemCountSubject.asObservable();
  }
}
