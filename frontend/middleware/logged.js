export default function({ redirect, $auth }) {
 
  if(!$auth.loggedIn){  
    redirect('/login');
  }
  
}
