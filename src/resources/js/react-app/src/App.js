import * as React from 'react';
import { BrowserRouter, Routes, Route, Router } from "react-router-dom";
import SignIn from './sign-in/SignIn';
import SignUp from './sign-up/SignUp';
import Dashboard from './dashboard/Dashboard';

function App() {
  return (
  <BrowserRouter>
    <Routes>
      <Route path="/login" element={<SignIn />} />
      <Route path="/register" element={<SignUp />} />
      <Route path="/dashboard" element={<Dashboard />} />
      <Route path="/" element={<SignIn />} /> 
    </Routes>
  </BrowserRouter>
  );
}

export default App;
