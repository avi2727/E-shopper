import { Injectable } from '@angular/core';
import { BehaviorSubject, catchError, map, Observable, of, Subject } from 'rxjs';
import { UserdataService } from './services/userdata.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private loginEvent = new Subject<void>();
  private logoutEvent = new Subject<void>();
  private userLoggedIn = new BehaviorSubject<boolean>(false);

  constructor(
    private userdataService: UserdataService,
  ) {
    
    // Initialize userLoggedIn based on the presence of user token
    this.userLoggedIn.next(this.isUserTokenPresent());
  }
 
  
  loginUser(credentials: { email: string, password: string }): Observable<{success: boolean, message?: string}> {
      return this.userdataService.loginUser(credentials).pipe(
        map((res: any) => {
          if (res.code === 1) {
            sessionStorage.setItem('userData', JSON.stringify(res));
            sessionStorage.setItem('userToken', res.usertoken);
            this.userdataService.setUserName(res.userName);
            this.logoutEvent.next();
            return { success: true, message: res.message };
          } else {
            sessionStorage.setItem('userData', '');
            return { success: false, message: res.message || 'Login failed.' };
          }
        }),
        catchError((error: any) => {
          console.error('Login error:', error);
          let errorMsg = 'An unexpected error occurred.';
          if (error.error && error.error.message) {
            errorMsg = error.error.message;
            if (error.error.errors) {
              const firstErrorKey = Object.keys(error.error.errors)[0];
              errorMsg = error.error.errors[firstErrorKey][0];
            }
          }
          return of({ success: false, message: errorMsg });
        })
      );
    }
    signupfun(credentials: { email: string, password: string, userName:string }): Observable<{success: boolean, message?: string}> {
      return this.userdataService.SignupUser(credentials).pipe(
        map((res: any) => {
          if (res.code === 1) {
            sessionStorage.setItem('userData', JSON.stringify(res));
            sessionStorage.setItem('userToken', res.usertoken);
            this.userdataService.setUserName(res.userName);
            this.logoutEvent.next();
            return { success: true, message: res.message };
          } else {
            sessionStorage.setItem('userData', '');
            return { success: false, message: res.message || 'Registration failed.' };
          }
        }),
        catchError((error: any) => {
          console.error('Signup error:', error);
          let errorMsg = 'An unexpected error occurred during signup.';
          if (error.error && error.error.message) {
            errorMsg = error.error.message;
            if (error.error.errors) {
              const firstErrorKey = Object.keys(error.error.errors)[0];
              errorMsg = error.error.errors[firstErrorKey][0];
            }
          }
          return of({ success: false, message: errorMsg });
        })
      );
    }
  

    logoutUser(): Observable<boolean> {
      return this.userdataService.logoutUser().pipe(
        map((res: any) => {
          if (res.code == 1) {
      sessionStorage.removeItem('userData');
      sessionStorage.removeItem('userToken');
            this.logoutEvent.next();
            return true;
         
          } else {
            return false;
          }
        }),
        catchError((error: any) => {
          console.error('Logout error:', error);
          return of(false);
        })
      );
    }

  getUserLoggedIn(): Observable<boolean> {
    return this.userLoggedIn.asObservable();
  }

  private isUserTokenPresent(): boolean {
    // Replace this logic with your actual check for user token presence
    return !!sessionStorage.getItem('userToken'); // For demonstration purposes
  }

  isAuthenticated(): boolean {
    return this.isUserTokenPresent(); // Check if user token is present
  }
  onLogin(): Observable<void> {
    return this.loginEvent.asObservable();
  }

  onLogout(): Observable<void> {
    return this.logoutEvent.asObservable();
  }

}
