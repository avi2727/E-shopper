import { Component, Input, OnInit, OnDestroy, ChangeDetectorRef } from '@angular/core';
import { Router } from '@angular/router';
import { UserdataService } from '../services/userdata.service';
import { FormGroup, FormControl } from '@angular/forms';
import { Subscription } from 'rxjs'; // Import Subscription
import { SharedCartService } from '../shared-cart.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit, OnDestroy { 
  userName: string | null = null;
  loginForm: FormGroup;
  target: string = '';
  token: any;
  signup: FormGroup;
  signInButton: any;
  usersessionData: any;
  @Input() cartItemCount: number = 0;
  private cartItemCountSubscription: Subscription | undefined; 
  authSubscription: Subscription | undefined;
  
  constructor(
    private userdataService: UserdataService,
    private router: Router,
    private sharedCartService: SharedCartService,
    private authService: AuthService
  ) {
    // this.autoSignIn();
    this.loginForm = new FormGroup({
      email: new FormControl(''),
      password: new FormControl('')
    });

    this.signup = new FormGroup({
      email: new FormControl(''),
      password: new FormControl(''),
      userName: new FormControl('')
    });
  }

  ngOnInit() {
    // this.autoSignIn();  // Auto sign-in when the page loads
  this.cartItemCountSubscription = this.sharedCartService.getCartItemCount().subscribe(count => {
      this.cartItemCount = count;
    });

    //alert(this.cartItemCount);
    this.userdataService.userName$.subscribe(userName => {
      this.userName = userName;
    });
   
    this.authSubscription = this.authService.getUserLoggedIn().subscribe(isLoggedIn => {
      this.updateAuthenticationMessage(isLoggedIn);
    });

  }
  ngOnDestroy() {
    if (this.cartItemCountSubscription) {
      this.cartItemCountSubscription.unsubscribe();
    }
    if (this.authSubscription) {
      this.authSubscription.unsubscribe();
    }
  }
  
  loginUser() {
    if (this.loginForm.invalid) {
      return;
    }
  
    const credentials = {
      email: this.loginForm.value.email,
      password: this.loginForm.value.password,
    };
  
    this.authService.loginUser(credentials).subscribe((res: any) => {
      if (res.success) {
        this.target = `<div class="alert alert-success">${res.message || 'Login successful.'}</div>`;
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        this.target = `<div class="alert alert-danger">${res.message || 'Login failed.'}</div>`;
        setTimeout(() => {
          this.target = '';
        }, 3000); // give them 3 seconds to see it
      }
    });
  }
 
  signupfun() {
    if (this.signup.invalid) {
      this.target = '<div class="alert alert-danger">Please fill in all fields correctly.</div>';
      setTimeout(() => { this.target = ''; }, 3000);
      return;
    }
  
    const credentials = {
      email: this.signup.value.email,
      password: this.signup.value.password,
      userName: this.signup.value.userName,
    };
  
    this.authService.signupfun(credentials).subscribe((res: any) => {
      if (res.success) {
        this.target = `<div class="alert alert-success">${res.message || 'SignUp successful.'}</div>`;
        this.signup.reset(); // clear form
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      } else {
        this.target = `<div class="alert alert-danger">${res.message || 'SignUp failed.'}</div>`;
        setTimeout(() => {
          this.target = '';
        }, 3000);
      }
    });
  }
  logout() {
    this.authService.logoutUser().subscribe((loggedOut: boolean) => {
      if (loggedOut) {
        this.clearUserDataAndNavigate();
      } else {
        // Handle logout failure (show error message, etc.)
        console.error('Logout failed');
      }
    });
  }
  private clearUserDataAndNavigate() {
    this.userdataService.setUserName('guest'); // Clear username through service
    this.router.navigate(['/']); // Navigate to the appropriate component
  }
 
  private updateAuthenticationMessage(isLoggedIn: boolean) {
    if (isLoggedIn) {
      this.target = '<div class="alert alert-success">User is logged in.</div>';
    } else {
      this.target = '<div class="alert alert-danger">User is logged out.</div>';
    }
    setTimeout(() => {
           this.target = '';
       }, 2000);
  }

  
}


