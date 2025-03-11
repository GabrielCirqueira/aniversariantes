import React from 'react'
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import ReactDOM from 'react-dom/client'
import { ChakraProvider } from '@chakra-ui/react'
import Home from '@components/pages/Home'
import Pessoas from '@components/pages/Pessoas'

const element = document.getElementById('root') as HTMLElement;
const root = ReactDOM.createRoot(element);

root.render(
  <ChakraProvider>
    <Router>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/pessoas" element={<Pessoas />} />
      </Routes>
    </Router>
  </ChakraProvider>
);