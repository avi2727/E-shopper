import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';

export const authGuard: CanActivateFn = (route, state) => {
  let _router=inject(Router)
  const isLoggedin = sessionStorage.getItem('userData');
   if(!isLoggedin){
    alert("Please login to Access!!");
    _router.navigate(['/']);
   }
  return true;
};
