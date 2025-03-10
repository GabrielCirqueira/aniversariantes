import { useEffect, useState } from "react";
import { motion } from "framer-motion";

export default function AniversariantesSlide() {
  const [dados, setDados] = useState<string[]>([]);
  const [index, setIndex] = useState(0);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("/v1/api/aniversariantes")
      .then((res) => res.json())
      .then((data) => {
        if (data && data.dados) {
          const aniversariantes = Object.values(data.dados).map(
            (pessoa: any) => `${pessoa.nome} - ${pessoa.dataNascimento}`
          );
          setDados(aniversariantes);
        }
        setLoading(false);
      })
      .catch((error) => {
        console.error("Erro ao buscar dados:", error);
        setLoading(false);
      });
  }, []);

  useEffect(() => {
    if (dados.length > 0) {
      const interval = setInterval(() => {
        setIndex((prevIndex) => (prevIndex + 1) % dados.length);
      }, 3000);
      return () => clearInterval(interval);
    }
  }, [dados]);

  if (loading) return <p>Carregando...</p>;
  if (dados.length === 0) return <p>Nenhum aniversariante encontrado.</p>;

  return (
    <div className="flex justify-center items-center h-40 w-full overflow-hidden bg-gray-900 text-white text-xl font-bold">
      <motion.div
        key={index}
        initial={{ y: 50, opacity: 0 }}
        animate={{ y: 0, opacity: 1 }}
        exit={{ y: -50, opacity: 0 }}
        transition={{ duration: 0.8 }}
        className="absolute"
      >
        {dados[index]}
      </motion.div>
    </div>
  );
}